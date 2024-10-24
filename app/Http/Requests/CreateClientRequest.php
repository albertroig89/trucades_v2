<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Phone;

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
            'email' => 'nullable|email|unique:clients,email',
            'phone' => 'required|string|regex:/^[0-9]+$/|max:20',
            'phones' => 'nullable|array',
            'phones.*' => 'nullable|string|regex:/^[0-9]+$/|max:20',
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
            'phone.required' => 'Es obligatorio introducir un teléfono como minimo',
            'phone.regex' => 'El teléfono debe ser numerico',
            'phone.max' => 'El teléfono no debe superar los 20 digitos',
            'phones.*.regex' => 'El teléfono debe ser numerico',
            'phones.*.max' => 'El teléfono no debe superar los 20 digitos',
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
            $client->phones()->create([
                'phone' => $data['phone'],
            ]);

            // Crear teléfonos adicionales si existen
            if (!empty($data['phones'])) {
                foreach ($data['phones'] as $phone) {
                    $client->phones()->create([
                        'phone' => $phone,
                    ]);
                }
            }
        });
    }
}
