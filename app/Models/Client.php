<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    // Especifica la tabla en la base de datos
    protected $table = "clients";

    // Atributos que se pueden llenar de forma masiva
    protected $fillable = [
        'name', 'email'
    ];

    // Relación uno a muchos con el modelo Call
    public function client()
    {
        return $this->hasMany(Call::class);
    }

    // Relación uno a muchos con el modelo Phone
    public function phone()
    {
        return $this->hasMany(Phone::class);
    }

    // Relación uno a muchos con el modelo Job
    public function job()
    {
        return $this->hasMany(Job::class);
    }

    // Scope para filtrar por nombre
    public function scopeName($query, $name)
    {
        if (trim($name) != "") {
            $query->where('name', "LIKE", "%$name%");
        }
    }
}
