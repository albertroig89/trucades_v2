<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    // Atributos que se pueden llenar de forma masiva
    protected $fillable = [
        'user_id', 'client_id', 'stat_id', 'user_id2', 'callinf', 'clientphone',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relación con el modelo Stat
    public function stat()
    {
        return $this->belongsTo(Stat::class);
    }
}
