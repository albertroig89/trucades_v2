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
        return [];
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

        // Verificar si $jobs tiene registros
        if ($jobs->isEmpty()) {
            return redirect()->back()->with('error', 'No se encontraron trabajos para exportar.');
        }

        // Lógica para exportar y eliminar
        $response = null;
        switch ($exportFormat) {
            case 'csv':
                $response = $this->exportToCSV($jobs, $inittime, $endtime);
                break;
            case 'excel':
                $response = $this->exportToExcel($jobs, $inittime, $endtime, $client_id, $user_id);
                break;
            case 'pdf':
                $response = $this->exportToPDF($jobs, $inittime, $endtime, $client_id, $user_id);
                break;
            case 'print':
                // Sí se seleccionó eliminar después de exportar para impresión
                if ($deleteAfterExport) {
                    $this->deleteJobsWithHistory($jobs);
                    session()->flash('success', 'Los trabajos han sido exportados y eliminados con éxito.');
                }
                return $this->exportToPrinter($jobs, $inittime, $endtime, $client_id, $user_id);
            case 'delete':
                $this->deleteJobsWithHistory($jobs);
                return redirect()->back()->with('success', 'Los trabajos han sido eliminados con éxito.');
            default:
                return redirect()->back()->with('error', 'Formato de exportación no soportado.');
        }

        // Sí se seleccionó eliminar después de exportar para otros formatos
        if ($deleteAfterExport) {
            $this->deleteJobsWithHistory($jobs);
            session()->flash('success', 'Los trabajos han sido exportados y eliminados con éxito.');
        }

        return $response;
    }

    protected function deleteJobsWithHistory($jobs)
    {
        foreach ($jobs as $job) {
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

            $job->delete();
        }
    }

    protected function exportToCSV($jobs, $inittime, $endtime)
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

        $filename = 'trabajos_exportados_' . now()->format('d-m-y_H-i') . '_entre_el_' . $inittime->format('d-m-y') . '_y_el_' . $endtime->format('d-m-y') . '.csv';

        $handle = fopen(storage_path('app/public/' . $filename), 'w');
        fputcsv($handle, array_keys($csvData[0]));

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
    }

    protected function exportToExcel($jobs, $inittime, $endtime, $client_id, $user_id)
    {
        $filename = 'trabajos_exportados_' . now()->format('d-m-y_H-i') . '.xlsx';
        Excel::store(new ExcelJobsExport($jobs, $inittime, $endtime, $client_id, $user_id), $filename, 'public');

        return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
    }

    protected function exportToPDF($jobs, $inittime, $endtime, $client_id, $user_id)
    {
        $formattedInitDate = Carbon::parse($inittime)->format('d-m-y');
        $formattedEndDate = Carbon::parse($endtime)->format('d-m-y');
        $title = 'Exportación de trabajos a PDF entre ' . $formattedInitDate . ' y el ' . $formattedEndDate;

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

        $totalMinutes = $jobs->sum('totalmin');
        $totalHours = number_format($totalMinutes / 60, 2);

        $pdf = Pdf::loadView('jobs.exportpdf', compact('jobs', 'title', 'totalMinutes', 'totalHours', 'client_id', 'user_id'))
            ->setPaper('a4', 'landscape');

        $filename = 'trabajos_exportados_' . now()->format('d-m-y_H-i') . '.pdf';

        return $pdf->download($filename);
    }

    protected function exportToPrinter($jobs, $inittime, $endtime, $client_id, $user_id)
    {
        $formattedInitDate = Carbon::parse($inittime)->format('d-m-y');
        $formattedEndDate = Carbon::parse($endtime)->format('d-m-y');
        $title = 'Exportación de trabajos para impresión entre ' . $formattedInitDate . ' y el ' . $formattedEndDate;

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

        $totalMinutes = $jobs->sum('totalmin');
        $totalHours = number_format($totalMinutes / 60, 2);

        return view('jobs.exportpdf', compact('jobs', 'title', 'totalMinutes', 'totalHours', 'client_id', 'user_id'))->with([
            'print' => true
        ]);
    }
}




