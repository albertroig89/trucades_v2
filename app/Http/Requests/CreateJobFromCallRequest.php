<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Job;

class CreateJobFromCallRequest extends FormRequest
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
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages()
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
     * Create a new job from the request data.
     *
     * @return void
     */
    public function createJobFromCall()
    {
        DB::transaction(function () {
            $data = $this->validated();

            // Convertir las fechas a objetos Carbon
            $inittime = Carbon::createFromFormat('d-m-Y H:i', $data['inittime']);
            $endtime = Carbon::createFromFormat('d-m-Y H:i', $data['endtime']);

            // Crear el trabajo
            Job::create([
                'user_id' => auth()->id(), // Asignamos el ID del usuario autenticado
                'client_id' => $data['client_id'] ?? null,
                'job' => $data['job'],
                'inittime' => $inittime,
                'endtime' => $endtime,
                'totalmin' => abs($endtime->diffInMinutes($inittime)),
                'clientname' => $data['clientname'],
            ]);
        });
    }
}
