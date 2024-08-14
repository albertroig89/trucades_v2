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
            'user_id' => 'required|exists:users,id',
            'client_id' => 'nullable|exists:clients,id',
            'callinf' => 'required|string',
            'inittime' => 'required|date_format:d-m-Y H:i',
            'endtime' => 'required|date_format:d-m-Y H:i',
            'clientname' => 'required_if:client_id,null|string',
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
            'user_id.required' => 'Selecciona un empleat',
            'user_id.exists' => 'L\'empleat seleccionat no existeix',
            'callinf.required' => 'Introdueix la informació de la feina',
            'inittime.required' => 'Introdueix el començament de la feina',
            'inittime.date_format' => 'El format de la data d\'inici no és vàlid',
            'endtime.required' => 'Introdueix el final de la feina',
            'endtime.date_format' => 'El format de la data de finalització no és vàlid',
            'clientname.required_if' => 'Selecciona un client o escriu-ne un',
            'clientname.string' => 'El nom del client ha de ser una cadena de text',
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
                'user_id' => $data['user_id'],
                'client_id' => $data['client_id'] ?? null,
                'job' => $data['callinf'],
                'inittime' => $inittime,
                'endtime' => $endtime,
                'totalmin' => $endtime->diffInMinutes($inittime),
                'clientname' => $data['clientname'],
            ]);
        });
    }
}
