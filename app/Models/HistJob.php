<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistJob extends Model
{
    // Atributos que se pueden llenar de forma masiva
    protected $fillable = [
        'username', 'job', 'inittime', 'endtime', 'totalmin', 'clientname',
    ];
}
