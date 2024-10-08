<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Client;

class CreateClientRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email', // Cambiado a clients para la tabla correcta
            'phone' => 'required|string|max:20',
            'phones' => 'nullable|array',
            'phones.*' => 'nullable|string|max:20', // Validación para cada teléfono adicional
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
            'name.required' => 'Introduce un nombre para el cliente',
            'email.email' => 'Introduce un correo electrónico válido',
            'email.unique' => 'El correo electrónico ya existe',
            'phone.required' => 'Introduce un telèfono',
            'phones.array' => 'Los teléfonos adicionales deben ser una matriz válida',
            'phones.*.string' => 'Los telefonos addicionales tienen que ser cadenas de texto',
        ];
    }

    /**
     * Create a new client record in the database.
     *
     * @return void
     */
    public function createClient()
    {
        DB::transaction(function () {
            $data = $this->validated();

            // Crear el cliente
            $client = Client::create([
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
            ]);

            // Crear el primer teléfono
            $client->phone()->create([
                'phone' => $data['phone'],
            ]);

            // Crear teléfonos adicionales si existen
            if (!empty($data['phones'])) {
                foreach ($data['phones'] as $phone) {
                    $client->phone()->create([
                        'phone' => $phone,
                    ]);
                }
            }
        });
    }
}
