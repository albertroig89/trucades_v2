<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    // Atributos que se pueden llenar de forma masiva
    protected $fillable = [
        'title',
    ];

    // Relación uno a muchos con el modelo User
    public function department()
    {
        return $this->hasMany(User::class);
    }
}
