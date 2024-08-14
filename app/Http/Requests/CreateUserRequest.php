<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class CreateUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'department_id' => 'required|exists:departments,id',
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
            'name.required' => 'El nom és obligatori',
            'name.string' => 'El nom ha de ser una cadena de text',
            'name.max' => 'El nom no pot superar els 255 caràcters',
            'email.required' => 'Introdueix un correu electrònic',
            'email.email' => 'Introdueix un correu electrònic vàlid',
            'email.unique' => 'El correu electrònic ja existeix',
            'password.required' => 'Especifica una contrasenya',
            'password.min' => 'La contrasenya ha de tenir almenys 6 caràcters',
            'password.confirmed' => 'Les contrasenyes no coincideixen',
            'department_id.required' => 'El departament és obligatori',
            'department_id.exists' => 'El departament seleccionat no existeix',
        ];
    }

    /**
     * Create a new user from the validated request data.
     *
     * @return void
     */
    public function createUser()
    {
        DB::transaction(function () {
            $data = $this->validated();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'department_id' => $data['department_id'],
            ]);

            // Si tienes un perfil asociado al usuario, descomenta y ajusta esto según sea necesario
            // $user->profile()->create([
            //     'bio' => $data['bio'] ?? null,
            //     'twitter' => $data['twitter'] ?? null,
            // ]);
        });
    }

}
