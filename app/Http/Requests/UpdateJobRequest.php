<?php

namespace App\Http\Requests;

use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateJobRequest extends FormRequest
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
            'client_id' => 'nullable|exists:clients,id',
            'job' => 'required|string',
            'inittime' => 'required|date_format:d-m-Y H:i',
            'endtime' => 'required|date_format:d-m-Y H:i|after:inittime',
            'clientname' => 'required|string|max:255',
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'clientname.required' => 'Selecciona un cliente o escribe uno',
            'clientname.max' => 'El nombre del cliente no puede exceder los 255 caracteres',
            'job.required' => 'Introduce la descripción del trabajo realizado',
            'inittime.required' => 'Introduce la hora de inicio del trabajo',
            'inittime.date_format' => 'El formato de la hora de inicio no es válido',
            'endtime.required' => 'Introduce la hora de finalización del trabajo',
            'endtime.date_format' => 'El formato de la hora de finalización no es válido',
            'endtime.after' => 'La hora de finalización debe ser posterior a la hora de inicio',
        ];
    }

    /**
     * Update the existing job with the validated request data.
     *
     * @param Job $job
     * @return void
     */
    public function updateJob(Job $job): void
    {
        DB::transaction(function () use ($job) {
            $data = $this->validated();

            $inittime = Carbon::createFromFormat('d-m-Y H:i', $data['inittime'])->setTimezone(config('app.timezone'));
            $endtime = Carbon::createFromFormat('d-m-Y H:i', $data['endtime'])->setTimezone(config('app.timezone'));

            $totalMinutes = abs($endtime->diffInMinutes($inittime));

            // Actualizar los datos del trabajo
            $jobData = [
                'job' => $data['job'],
                'inittime' => $inittime,
                'endtime' => $endtime,
                'totalmin' => $totalMinutes,
                'clientname' => $data['clientname'],
            ];

            // Agregar client_id si está presente
            if (!empty($data['client_id'])) {
                $jobData['client_id'] = $data['client_id'];
            }

            // Actualizar el trabajo existente
            $job->update($jobData);
        });
    }
}

