<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    // Atributos que se pueden llenar de forma masiva
    protected $fillable = [
        'title',
    ];

    // Relación de uno a muchos con el modelo Call
    public function stats()
    {
        return $this->hasMany(Call::class);
    }
}
