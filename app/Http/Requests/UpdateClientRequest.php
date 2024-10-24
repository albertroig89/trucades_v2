<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateClientRequest extends FormRequest
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
            'email' => 'nullable|email',
            'phone' => 'required|string|regex:/^[0-9]+$/|max:20',
            'phones' => 'nullable|array',
            'phones.*' => 'nullable|string|regex:/^[0-9]+$/|max:20',
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
            'name.required' => 'Introduce un nombre para el cliente',
            'email.email' => 'Introduce un correo electrónico válido',
            'phone.required' => 'Es obligatorio introducir un telèfono como minimo',
            'phone.regex' => 'El teléfono debe ser numerico',
            'phone.max' => 'El teléfono no debe superar los 20 digitos',
            'phones.*.regex' => 'El teléfono debe ser numerico',
            'phones.*.max' => 'El teléfono no debe superar los 20 digitos',
        ];
    }

    public function updateClient(Client $client)
    {
        DB::transaction(function () use ($client) {
            $data = $this->validated();

            // Actualizar los datos principales del cliente
            $client->update([
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
            ]);

            // Gestionar los registros de teléfonos adicionales
            $phones = $data['phones'] ?? []; // Si no hay teléfonos adicionales, usa un array vacío

            // Eliminar todos los teléfonos anteriores
            $client->phones()->delete();

            // Agregar el teléfono principal si no está vacío
            if (!empty($data['phone'])) {
                $client->phones()->create(['phone' => $data['phone']]);
            }

            // Crear los teléfonos adicionales si existen
            foreach ($phones as $phone) {
                if (!empty($phone)) {
                    $client->phones()->create(['phone' => $phone]);
                }
            }
        });
    }
}
