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
        $isFromHistory = $this->input('export_from_history', false) === 'true'; // Detectar si se exporta del histórico
        $inittime = Carbon::parse($this->input('initdate'));
        $endtime = Carbon::parse($this->input('enddate'))->endOfDay();
        $client_id = $this->input('client_id');
        $user_id = $this->input('user_id');
        $exportFormat = $this->input('export_format');
        $deleteAfterExport = $this->has('delete_after_export');

        // Seleccionar la base de datos: trabajos o histórico
        $baseQuery = $isFromHistory ? HistJob::query() : Job::query();

        // Construir la consulta para obtener los trabajos
        $jobsQuery = $baseQuery->whereBetween('inittime', [$inittime, $endtime])
            ->orderBy($isFromHistory ? 'clientname' : 'client_id') // Condicional para histórico
            ->orderBy($isFromHistory ? 'username' : 'user_id')     // Condicional para histórico
            ->orderBy('inittime');

        if ($client_id) {
            $jobsQuery->where($isFromHistory ? 'clientname' : 'client_id', $client_id);
        }

        if ($user_id) {
            $jobsQuery->where($isFromHistory ? 'username' : 'user_id', $user_id);
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
                $response = $this->exportToCSV($jobs, $inittime, $endtime, $isFromHistory);
                break;
            case 'excel':
                $response = $this->exportToExcel($jobs, $inittime, $endtime, $client_id, $user_id, $isFromHistory);
                break;
            case 'pdf':
                $response = $this->exportToPDF($jobs, $inittime, $endtime, $client_id, $user_id, $isFromHistory);
                break;
            case 'print':
                if ($deleteAfterExport) {
                    $this->deleteJobsWithHistory($jobs);
                    session()->flash('success', 'Los trabajos han sido exportados y eliminados con éxito.');
                }
                return $this->exportToPrinter($jobs, $inittime, $endtime, $client_id, $user_id, $isFromHistory);
            case 'delete':
                $this->deleteJobsWithHistory($jobs);
                return redirect()->back()->with('success', 'Los trabajos han sido eliminados con éxito.');
            default:
                return redirect()->back()->with('error', 'Formato de exportación no soportado.');
        }

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
                'username' => $job->user->name ?? $job->username,
                'email' => $job->user->email ?? null,
                'avatar' => $job->user->avatar ?? null,
                'attempts' => $job->attempts,
                'job' => $job->job,
                'inittime' => $job->inittime,
                'endtime' => $job->endtime,
                'totalmin' => $job->totalmin,
                'clientname' => $job->clientname ?? null,
            ]);

            $job->delete();
        }
    }

    protected function exportToCSV($jobs, $inittime, $endtime, $isFromHistory)
    {
        $csvData = [];

        foreach ($jobs as $job) {
            $csvData[] = [
                'Empleado' => $isFromHistory ? ($job->username ?? 'N/A') : ($job->user->name ?? 'N/A'),
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

    protected function exportToExcel($jobs, $inittime, $endtime, $client_id, $user_id, $isFromHistory)
    {
        $filename = 'trabajos_exportados_' . now()->format('d-m-y_H-i') . '.xlsx';
        Excel::store(new ExcelJobsExport($jobs, $inittime, $endtime, $client_id, $user_id, $isFromHistory), $filename, 'public');

        return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
    }

    protected function exportToPDF($jobs, $inittime, $endtime, $client_id, $user_id, $isFromHistory)
    {
        $formattedInitDate = Carbon::parse($inittime)->format('d-m-y');
        $formattedEndDate = Carbon::parse($endtime)->format('d-m-y');

        if ($isFromHistory) {
            $title = 'Exportación de trabajos del histórico a PDF entre ' . $formattedInitDate . ' y el ' . $formattedEndDate;
        }else{
            $title = 'Exportación de trabajos a PDF entre ' . $formattedInitDate . ' y el ' . $formattedEndDate;
        }


        if ($client_id) {
            $clientName = $isFromHistory
                ? ($jobs->first()->clientname ?? 'N/A')
                : (Client::find($client_id)?->name ?? 'N/A');
            $title .= ' para el cliente ' . $clientName;
        }

        if ($user_id) {
            $userName = $isFromHistory
                ? ($jobs->first()->username ?? 'N/A')
                : (User::find($user_id)?->name ?? 'N/A');
            $title .= ' por el usuario ' . $userName;
        }

        $totalMinutes = $jobs->sum('totalmin');
        $totalHours = number_format($totalMinutes / 60, 2);

        $pdf = Pdf::loadView('jobs.exportpdf', compact('jobs', 'title', 'totalMinutes', 'totalHours', 'client_id', 'user_id', 'isFromHistory'))
            ->setPaper('a4', 'landscape');

        $filename = 'trabajos_exportados_' . now()->format('d-m-y_H-i') . '.pdf';

        return $pdf->download($filename);
    }

    protected function exportToPrinter($jobs, $inittime, $endtime, $client_id, $user_id, $isFromHistory)
    {
        $formattedInitDate = Carbon::parse($inittime)->format('d-m-y');
        $formattedEndDate = Carbon::parse($endtime)->format('d-m-y');

        if($isFromHistory){
            $title = 'Exportación de trabajos del histórico para impresión entre ' . $formattedInitDate . ' y el ' . $formattedEndDate;
        }else{
            $title = 'Exportación de trabajos para impresión entre ' . $formattedInitDate . ' y el ' . $formattedEndDate;
        }


        if ($client_id) {
            $clientName = $isFromHistory
                ? ($jobs->first()->clientname ?? 'N/A')
                : (Client::find($client_id)?->name ?? 'N/A');
            $title .= ' para el cliente ' . $clientName;
        }

        if ($user_id) {
            $userName = $isFromHistory
                ? ($jobs->first()->username ?? 'N/A')
                : (User::find($user_id)?->name ?? 'N/A');
            $title .= ' por el usuario ' . $userName;
        }

        $totalMinutes = $jobs->sum('totalmin');
        $totalHours = number_format($totalMinutes / 60, 2);

        return view('jobs.exportpdf', compact('jobs', 'title', 'totalMinutes', 'totalHours', 'client_id', 'user_id', 'isFromHistory'))->with([
            'print' => true
        ]);
    }
}




