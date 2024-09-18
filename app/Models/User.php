<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Los atributos que se pueden llenar de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'department_id', 'name', 'email', 'desktop', 'password', 'avatar',
    ];

    /**
     * Los atributos que deberían estar ocultos en los arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Buscar un usuario por su correo electrónico.
     *
     * @param  string  $email
     * @return \App\Models\User|null
     */
    public static function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    /**
     * Relación de pertenencia con el modelo Department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Relación uno a muchos con el modelo Job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function job()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Los atributos que deberían ser convertidos a tipos de datos nativos.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Verifica si el usuario es administrador.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * Eliminar el avatar del usuario cuando el usuario es eliminado
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // Verificar si el usuario tiene un avatar
            if ($user->avatar) {
                // Eliminar el prefijo 'storage/' de la ruta del avatar
                $avatarPath = str_replace('storage/', '', $user->avatar);

                // Verificar si el archivo del avatar existe en el sistema de archivos
                if (Storage::disk('public')->exists($avatarPath)) {
                    \Log::info('Eliminando avatar del usuario: ' . $user->avatar);
                    // Eliminar el archivo del avatar
                    Storage::disk('public')->delete($avatarPath);
                } else {
                    \Log::info('Archivo no encontrado para el avatar: ' . $user->avatar);
                }
            }
        });
    }


}



















//<?php
//
//namespace App\Models;
//
//// use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
//
//class User extends Authenticatable
//{
//    use HasFactory, Notifiable;
//
//    /**
//     * The attributes that are mass assignable.
//     *
//     * @var array<int, string>
//     */
//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//    ];
//
//    /**
//     * The attributes that should be hidden for serialization.
//     *
//     * @var array<int, string>
//     */
//    protected $hidden = [
//        'password',
//        'remember_token',
//    ];
//
//    /**
//     * Get the attributes that should be cast.
//     *
//     * @return array<string, string>
//     */
//    protected function casts(): array
//    {
//        return [
//            'email_verified_at' => 'datetime',
//            'password' => 'hashed',
//        ];
//    }
//}
