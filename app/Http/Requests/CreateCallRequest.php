<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Call;

class CreateCallRequest extends FormRequest
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
            'user_id2' => 'required|exists:users,id',
            'stat_id' => 'required|exists:stats,id',
            'callinf' => 'required|string',
            'clientname' => 'nullable|string',
            'clientphone' => 'nullable|string',
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
            'user_id.exists' => 'El empleat seleccionado no existeix',
            'client_id.exists' => 'El client seleccionado no existeix',
            'user_id2.required' => 'Selecciona un segon empleat',
            'user_id2.exists' => 'El segon empleat seleccionado no existeix',
            'stat_id.required' => 'Selecciona un estat',
            'stat_id.exists' => 'L\'estat seleccionado no existeix',
            'callinf.required' => 'Omple l\'informació de la trucada',
            'clientname.string' => 'El nom del client ha de ser una cadena de text',
            'clientphone.string' => 'El telèfon del client ha de ser una cadena de text',
        ];
    }

    /**
     * Create a new call record in the database.
     *
     * @return void
     */
    public function createCall()
    {
        DB::transaction(function () {
            $data = $this->validated();

            // Crear el registro de llamada
            Call::create([
                'user_id' => $data['user_id'],
                'client_id' => $data['client_id'] ?? null,
                'user_id2' => $data['user_id2'],
                'stat_id' => $data['stat_id'],
                'callinf' => $data['callinf'],
                'clientname' => $data['clientname'] ?? null,
                'clientphone' => $data['clientphone'] ?? null,
            ]);
        });
    }
}
