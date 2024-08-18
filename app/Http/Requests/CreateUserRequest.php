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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'name.required' => 'EL nombre es obligatorio',
            'name.string' => 'El nombre tiene que ser una cadena de texto',
            'name.max' => 'El nombre no puede superar los 255 caracteres',
            'email.required' => 'Introduce un correo electronico',
            'email.email' => 'Introduce un correo electronico valido',
            'email.unique' => 'El correo electronico ya existe',
            'password.required' => 'Especifica una contrasenya',
            'password.min' => 'La contrasenya tiene que tener un minimo de 6 caracteres',
            'password.confirmed' => 'Las contrasenyas no coinciden',
            'department_id.required' => 'El departamento es obligatorio',
            'department_id.exists' => 'El departamento seleccionado no existe',
            'avatar.image' => 'La imagen tiene que ser una imagen',
            'avatar.mimes' => 'La imagen tiene que ser jpeg, png, jpg, gif o svg',
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
