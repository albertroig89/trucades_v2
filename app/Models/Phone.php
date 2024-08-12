<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;
    // Especifica el nombre de la tabla en la base de datos
    protected $table = "phones";

    // Atributos que se pueden llenar de forma masiva
    protected $fillable = [
        'client_id', 'phone',
    ];

    // Relación de pertenencia con el modelo Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

