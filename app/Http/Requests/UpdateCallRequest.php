<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCallRequest extends FormRequest
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
            'user_id' => 'required',
            'client_id' => 'nullable',
            'stat_id' => 'required',
            'callinf' => 'required',
            'clientname' => 'required',
            'clientphone' => 'nullable',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Selecciona un empleado',
            'clientname.required' => 'Selecciona un cliente o escribe uno',
            'stat_id.required' => 'Selecciona un estado',
            'callinf.required' => 'Rellena la información de la llamada'
        ];
    }
}
