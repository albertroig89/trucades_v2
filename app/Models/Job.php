<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    // Se utiliza para habilitar el uso de Eloquent Factory
    use HasFactory;

    // Atributos que se pueden llenar de forma masiva
    protected $fillable = [
        'user_id', 'client_id', 'job', 'inittime', 'endtime', 'totalmin', 'clientname', 'attempts',
    ];

    // Relación de pertenencia con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación de pertenencia con el modelo Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

