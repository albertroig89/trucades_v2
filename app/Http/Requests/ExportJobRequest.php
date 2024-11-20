<?php

namespace App\Http\Requests;

use App\Models\HistJob;
use App\Models\Job;
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
        $clientId = $this->input('client_id');
        $userId = $this->input('user_id');
        $exportFormat = $this->input('export_format');
        $deleteAfterExport = $this->has('delete_after_export');

        // Construir la consulta para obtener los trabajos
        $jobsQuery = Job::whereBetween('inittime', [$inittime, $endtime])
            ->orderBy('client_id')
            ->orderBy('user_id')
            ->orderBy('inittime');


        if ($clientId) {
            $jobsQuery->where('client_id', $clientId);
        }

        if ($userId) {
            $jobsQuery->where('user_id', $userId);
        }

        $jobs = $jobsQuery->get();

        // Lógica para exportar
        switch ($exportFormat) {
            case 'csv':
                return $this->exportToCSV($jobs, $deleteAfterExport, $inittime, $endtime);
            case 'excel':
                return $this->exportToExcel($jobs, $deleteAfterExport, $inittime, $endtime);
            case 'pdf':
                return $this->exportToPDF($jobs, $deleteAfterExport, $inittime, $endtime);
            case 'print':
                return $this->exportToPrinter($jobs, $deleteAfterExport, $inittime, $endtime);
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

    protected function exportToCSV($jobs, $deleteAfterExport)
    {
        $csvData = [];

        foreach ($jobs as $job) {
            $csvData[] = [
                'Empleado' => $job->user->name,
                'Fecha' => $job->created_at->format('d-m-Y H:i'),
                'Cliente' => $job->clientname,
                'Trabajo realizado' => $job->job,
                'Intentos' => $job->attempts,
                'Inicio del trabajo' => $job->inittime->format('d-m-Y H:i'),
                'Final del trabajo' => $job->endtime->format('d-m-Y H:i'),
                'Tiempo empleado' => $job->totalmin . ' min',
            ];
        }

        $filename = 'trabajos_exportados_' . now()->format('d-m-y_H-i') . '.csv';

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

    protected function exportToExcel($jobs, $deleteAfterExport, $inittime, $endtime)
    {
        $filename = 'trabajos_exportados_' . now()->format('d-m-y_H-i') . '.xlsx';

        // Utiliza Maatwebsite Excel para crear el archivo Excel
        Excel::store(new ExcelJobsExport($jobs, $inittime, $endtime), $filename, 'public');

        if ($deleteAfterExport) {
            $this->deleteJobsWithHistory($jobs);
        }

        return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
    }

    protected function exportToPDF($jobs, $deleteAfterExport, $inittime, $endtime)
    {
        // Formatear las fechas solo con día, mes y año
        $formattedInitDate = Carbon::parse($inittime)->format('d-m-y');
        $formattedEndDate = Carbon::parse($endtime)->format('d-m-y');

        $title = 'Exportacion de trabajos a PDF entre ' . $formattedInitDate . ' y el ' . $formattedEndDate;

        // Verificar si $jobs tiene registros
        if ($jobs->isEmpty()) {
            // Agregar un mensaje de depuración si no hay trabajos
            dd('No se encontraron trabajos para exportar');
        }

        // Calcular el total de minutos de todos los trabajos
        $totalMinutes = $jobs->sum('totalmin');
        $totalHours = number_format($totalMinutes / 60, 2); // Convertir minutos a horas con 2 decimales

        $pdf = Pdf::loadView('jobs.exportpdf', compact('jobs', 'title', 'totalMinutes', 'totalHours'))->setPaper('a4', 'landscape');
        $filename = 'trabajos_exportados_' . now()->format('d-m-y_H-i') . '.pdf';

        if ($deleteAfterExport) {
            $this->deleteJobsWithHistory($jobs);
        }

        return $pdf->download($filename);
    }

    protected function exportToPrinter($jobs, $deleteAfterExport, $inittime, $endtime)
    {
        // Formatear las fechas solo con día, mes y año
        $formattedInitDate = Carbon::parse($inittime)->format('d-m-y');
        $formattedEndDate = Carbon::parse($endtime)->format('d-m-y');

        $title = 'Impresión de trabajos entre ' . $formattedInitDate . ' y el ' . $formattedEndDate;

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

        // Renderizar la vista y pasar los datos
        return view('jobs.exportpdf', compact('jobs', 'title', 'totalMinutes', 'totalHours'))->with([
            'print' => true // Bandera para activar la impresión automática si es necesario
        ]);
    }
}
