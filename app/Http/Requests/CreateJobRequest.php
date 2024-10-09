<?php

namespace App\Http\Requests;

use App\Models\Job; // Asegúrate de que el modelo esté en el namespace correcto
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class CreateJobRequest extends FormRequest
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
            'clientname.string' => 'El nombre del cliente debe ser una cadena de texto',
            'job.required' => 'Introduce la descripción del trabajo realizado',
            'inittime.required' => 'Introduce la hora de inicio del trabajo',
            'inittime.date_format' => 'El formato de la hora de inicio no es válido',
            'endtime.required' => 'Introduce la hora de finalización del trabajo',
            'endtime.date_format' => 'El formato de la hora de finalización no es válido',
            'endtime.after' => 'La hora de finalización debe ser posterior a la hora de inicio',
        ];
    }

    /**
     * Create a new job from the validated request data.
     *
     * @return void
     */
    public function createJob(): void
    {
        DB::transaction(function () {
            $data = $this->validated();

            $inittime = Carbon::createFromFormat('d-m-Y H:i', $data['inittime'])->setTimezone(config('app.timezone'));
            $endtime = Carbon::createFromFormat('d-m-Y H:i', $data['endtime'])->setTimezone(config('app.timezone'));

            $totalMinutes = abs($endtime->diffInMinutes($inittime));


            // Definir los datos del trabajo
            $jobData = [
                'user_id' => auth()->id(), // Asignamos el ID del usuario autenticado
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

            // Crear el trabajo
            Job::create($jobData);
        });
    }
}

