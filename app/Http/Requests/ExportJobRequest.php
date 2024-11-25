<?php

namespace App\Http\Requests;

use App\Models\Client;
use App\Models\HistJob;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ExcelJobsExport;


class ExportJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }


    public function exportJobs()
    {
        $inittime = Carbon::parse($this->input('initdate'));
        $endtime = Carbon::parse($this->input('enddate'))->endOfDay();
        $client_id = $this->input('client_id');
        $user_id = $this->input('user_id');
        $exportFormat = $this->input('export_format');
        $deleteAfterExport = $this->has('delete_after_export');

        // Construir la consulta para obtener los trabajos
        $jobsQuery = Job::whereBetween('inittime', [$inittime, $endtime])
            ->orderBy('client_id')
            ->orderBy('user_id')
            ->orderBy('inittime');


        if ($client_id) {
            $jobsQuery->where('client_id', $client_id);
        }

        if ($user_id) {
            $jobsQuery->where('user_id', $user_id);
        }

        $jobs = $jobsQuery->get();

        // Lógica para exportar
        switch ($exportFormat) {
            case 'csv':
                return $this->exportToCSV($jobs, $deleteAfterExport, $inittime, $endtime);
            case 'excel':
                return $this->exportToExcel($jobs, $deleteAfterExport, $inittime, $endtime, $client_id, $user_id);
            case 'pdf':
                return $this->exportToPDF($jobs, $deleteAfterExport, $inittime, $endtime, $client_id, $user_id);
            case 'print':
                return $this->exportToPrinter($jobs, $deleteAfterExport, $inittime, $endtime, $client_id, $user_id);
            case 'delete':
                $this->deleteJobsWithHistory($jobs);
                return redirect()->route('jobs.index')->with('success', 'Los trabajos han sido eliminados con éxito.');
            default:
                return redirect()->back()->with('error', 'Formato de exportación no soportado.');
        }
    }

    protected function deleteJobsWithHistory($jobs)
    {
        foreach ($jobs as $job) {
            // Guardar en la tabla de historial antes de eliminar
            HistJob::create([
                'username' => $job->user->name,
                'email' => $job->user->email,
                'avatar' => $job->user->avatar,
                'attempts' => $job->attempts,
                'job' => $job->job,
                'inittime' => $job->inittime,
                'endtime' => $job->endtime,
                'totalmin' => $job->totalmin,
                'clientname' => $job->clientname,
            ]);

            // Eliminar el trabajo
            $job->delete();
        }
    }

    protected function exportToCSV($jobs, $deleteAfterExport, $inittime, $endtime)
    {
        $csvData = [];

        foreach ($jobs as $job) {
            $csvData[] = [
                'Empleado' => $job->user->name ?? 'N/A',
                'Fecha' => $job->created_at ? \Carbon\Carbon::parse($job->created_at)->format('d-m-Y H:i') : 'N/A',
                'Cliente' => $job->clientname ?? 'N/A',
                'Trabajo realizado' => $job->job ?? 'N/A',
                'Intentos' => $job->attempts ?? 0,
                'Inicio del trabajo' => $job->inittime ? \Carbon\Carbon::parse($job->inittime)->format('d-m-Y H:i') : 'N/A',
                'Final del trabajo' => $job->endtime ? \Carbon\Carbon::parse($job->endtime)->format('d-m-Y H:i') : 'N/A',
                'Tiempo empleado' => $job->totalmin ? $job->totalmin . ' min' : 'N/A',
            ];
        }

        $filename = 'trabajos_exportados_' . now()->format('d-m-y_H-i') . '_entre_el_' . $inittime->format('d-m-y') . '_y_el_' . $endtime->format('d-m-y') .'.csv';

        $handle = fopen(storage_path('app/public/' . $filename), 'w');
        fputcsv($handle, array_keys($csvData[0]));

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        if ($deleteAfterExport) {
            $this->deleteJobsWithHistory($jobs);
        }

        return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
    }

    protected function exportToExcel($jobs, $deleteAfterExport, $inittime, $endtime, $client_id, $user_id)
    {
        $filename = 'trabajos_exportados_' . now()->format('d-m-y_H-i') . '.xlsx';

        // Utiliza Maatwebsite Excel para crear el archivo Excel
        Excel::store(new ExcelJobsExport($jobs, $inittime, $endtime, $client_id, $user_id), $filename, 'public');

        if ($deleteAfterExport) {
            $this->deleteJobsWithHistory($jobs);
        }

        return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
    }

    protected function exportToPDF($jobs, $deleteAfterExport, $inittime, $endtime, $client_id, $user_id)
    {
        // Formatear las fechas solo con día, mes y año
        $formattedInitDate = Carbon::parse($inittime)->format('d-m-y');
        $formattedEndDate = Carbon::parse($endtime)->format('d-m-y');

        // Inicializar el título con las fechas de exportación
        $title = 'Exportación de trabajos a PDF entre ' . $formattedInitDate . ' y el ' . $formattedEndDate;

        // Obtener los nombres del cliente y usuario si están presentes
        if ($client_id) {
            $client = Client::find($client_id);
            $clientName = $client ? $client->name : '';
            $title .= ' para el cliente ' . $clientName;
        }

        if ($user_id) {
            $user = User::find($user_id);
            $userName = $user ? $user->name : '';
            $title .= ' por el usuario ' . $userName;
        }

        // Verificar si $jobs tiene registros
        if ($jobs->isEmpty()) {
            // Agregar un mensaje de depuración si no hay trabajos
            dd('No se encontraron trabajos para exportar');
        }

        // Calcular el total de minutos de todos los trabajos
        $totalMinutes = $jobs->sum('totalmin');
        $totalHours = number_format($totalMinutes / 60, 2); // Convertir minutos a horas con 2 decimales

        // Cargar la vista del PDF con los datos necesarios
        $pdf = Pdf::loadView('jobs.exportpdf', compact('jobs', 'title', 'totalMinutes', 'totalHours', 'client_id', 'user_id'))
            ->setPaper('a4', 'landscape');

        $filename = 'trabajos_exportados_' . now()->format('d-m-y_H-i') . '.pdf';

        if ($deleteAfterExport) {
            $this->deleteJobsWithHistory($jobs);
        }

        return $pdf->download($filename);
    }


    protected function exportToPrinter($jobs, $deleteAfterExport, $inittime, $endtime, $client_id, $user_id)
    {
        // Formatear las fechas solo con día, mes y año
        $formattedInitDate = Carbon::parse($inittime)->format('d-m-y');
        $formattedEndDate = Carbon::parse($endtime)->format('d-m-y');

        // Inicializar el título con las fechas de exportación
        $title = 'Exportación de trabajos para impresión entre ' . $formattedInitDate . ' y el ' . $formattedEndDate;

        // Obtener los nombres del cliente y usuario si están presentes
        if ($client_id) {
            $client = Client::find($client_id);
            $clientName = $client ? $client->name : '';
            $title .= ' para el cliente ' . $clientName;
        }

        if ($user_id) {
            $user = User::find($user_id);
            $userName = $user ? $user->name : '';
            $title .= ' por el usuario ' . $userName;
        }

        // Verificar si $jobs tiene registros
        if ($jobs->isEmpty()) {
            dd('No se encontraron trabajos para exportar');
        }

        // Calcular el total de minutos de todos los trabajos
        $totalMinutes = $jobs->sum('totalmin');
        $totalHours = number_format($totalMinutes / 60, 2); // Convertir minutos a horas con 2 decimales

        if ($deleteAfterExport) {
            $this->deleteJobsWithHistory($jobs);
        }

        // Renderizar la vista y pasar los datos, con la bandera 'print' activada para la impresión automática
        return view('jobs.exportpdf', compact('jobs', 'title', 'totalMinutes', 'totalHours', 'client_id', 'user_id'))->with([
            'print' => true // Bandera para activar la impresión automática si es necesario
        ]);
    }

}
