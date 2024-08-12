<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    // Atributos que se pueden llenar de forma masiva
    protected $fillable = [
        'title',
    ];

    // Relación de uno a muchos con el modelo Call
    public function stat()
    {
        return $this->hasMany(Call::class);
    }
}
