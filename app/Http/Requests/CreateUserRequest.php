<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'password' => 'required|string|min:8|confirmed',
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
            'name.required' => 'El nombre es obligatorio',
            'name.string' => 'El nombre tiene que ser una cadena de texto',
            'name.max' => 'El nombre no puede superar los 255 caracteres',
            'email.required' => 'Introduce un correo electrónico',
            'email.email' => 'Introduce un correo electrónico válido',
            'email.unique' => 'El correo electrónico ya existe',
            'password.required' => 'Especifica una contraseña',
            'password.min' => 'La contraseña tiene que tener un mínimo de 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'department_id.required' => 'El departamento es obligatorio',
            'department_id.exists' => 'El departamento seleccionado no existe',
            'avatar.image' => 'El avatar tiene que ser una imagen',
            'avatar.mimes' => 'La imagen tiene que ser jpeg, png, jpg, gif o svg',
            'avatar.max' => 'La imagen no puede ser mayor de 2MB',
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

            // Manejar la subida del archivo avatar o generar uno con las iniciales
            if (isset($data['avatar'])) {
                // Mover el archivo a una carpeta permanente, por ejemplo 'avatars'
                $avatarPath = 'storage/' . $data['avatar']->store('avatars', 'public');
            } else {
                // Generar un avatar con las iniciales del nombre
                $avatarPath = $this->generateAvatarFromInitials($data['name']);
            }

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'department_id' => $data['department_id'],
                'avatar' => $avatarPath, // Guardar la ruta final del avatar
            ]);
        });
    }

    /**
     * Genera un avatar con las iniciales del nombre de usuario.
     *
     * @param string $name Nombre completo del usuario.
     * @param int $width Ancho del avatar.
     * @param int $height Alto del avatar.
     * @return string Ruta del avatar generado.
     */
    public function generateAvatarFromInitials($name)
    {
        // Extraer las iniciales
        $words = explode(' ', trim($name));
        $initials = '';

        // Tomar la primera letra de cada palabra (máximo 2 letras)
        foreach ($words as $word) {
            if (strlen($initials) < 2) {
                $initials .= strtoupper($word[0]);
            } else {
                break;
            }
        }

        $width = 100;
        $height = 100;

        // Colores de fondo claros y oscuros
        $backgroundColors = [
            '#FFCDD2', '#F8BBD0', '#E1BEE7', '#BBDEFB', '#B3E5FC', '#B2EBF2', '#C8E6C9', '#DCEDC8', '#FFF9C4', '#FFE0B2',
            '#3F51B5', '#673AB7', '#009688', '#4CAF50', '#F44336', '#FF9800', '#9C27B0', '#2196F3', '#795548', '#607D8B'
        ];
        $backgroundColor = $backgroundColors[array_rand($backgroundColors)];

        // Determinar si el color de fondo es claro u oscuro
        list($r, $g, $b) = sscanf($backgroundColor, "#%02x%02x%02x");
        $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);

        // Usar blanco si el fondo es oscuro y negro si es claro
        $textColor = ($brightness > 150) ? [0, 0, 0] : [255, 255, 255];

        // Crear una imagen en blanco
        $image = imagecreatetruecolor($width, $height);

        // Colorear el fondo
        $background = imagecolorallocate($image, $r, $g, $b);
        imagefilledrectangle($image, 0, 0, $width, $height, $background);

        // Colorear el texto
        $textColorResource = imagecolorallocate($image, $textColor[0], $textColor[1], $textColor[2]);

        // Cargar la fuente (asegúrate de tener esta fuente en tu proyecto)
        $fontPath = public_path('fonts/Blanka-Regular.otf');

        // Tamaño de la fuente
        $fontSize = 40;

        // Calcular la caja delimitadora del texto
        $bbox = imagettfbbox($fontSize, 0, $fontPath, $initials);
        $textWidth = $bbox[2] - $bbox[0];
        $textHeight = abs($bbox[7] - $bbox[1]);

        // Calcular las coordenadas x e y para centrar el texto
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2 + $textHeight * 1.0;

        // Escribir el texto en la imagen
        imagettftext($image, $fontSize, 0, $x, $y, $textColorResource, $fontPath, $initials);

        // Guardar la imagen en la carpeta de almacenamiento correcta
        $avatarName = 'avatars/' . uniqid() . '.png';
        $avatarPath = storage_path('app/public/' . $avatarName); // Guardar en la carpeta 'storage/app/public/avatars'

        // Crear la carpeta si no existe
        if (!file_exists(dirname($avatarPath))) {
            mkdir(dirname($avatarPath), 0755, true);
        }

        imagepng($image, $avatarPath);

        // Liberar memoria
        imagedestroy($image);

        return 'storage/' . $avatarName; // Retornar la ruta correcta para acceder desde el navegador
    }












}

