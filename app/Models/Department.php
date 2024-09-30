<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // Atributos que se pueden llenar de forma masiva
    protected $fillable = [
        'title',
    ];

    // Relación uno a muchos con el modelo User
    public function departments()
    {
        return $this->hasMany(User::class);
    }
}
