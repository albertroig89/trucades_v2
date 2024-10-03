<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'client_id' => 'nullable',
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
    public function messages(): array
    {
        return [
            'user_id.required' => 'Selecciona un empleado',
            'clientname.required' => 'Selecciona un cliente o escribe uno',
            'job.required' => 'Introduce el trabajo realizado',
            'inittime.required' => 'Introduce el inicio del trabajo',
            'inittime.date_format' => 'El formato del inicio del trabajo es inválido',
            'endtime.required' => 'Introduce el final del trabajo',
            'endtime.date_format' => 'El formato del final del trabajo es inválido',
            'endtime.after' => 'El tiempo de finalización debe ser después del inicio',
        ];
    }
}
