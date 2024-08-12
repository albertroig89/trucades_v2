<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistJob2 extends Model
{
    // Especifica el nombre de la tabla en la base de datos
    protected $table = "hist_jobs2";

    // Atributos que se pueden llenar de forma masiva
    protected $fillable = [
        'username', 'job', 'inittime', 'endtime', 'totalmin', 'clientname',
    ];
}
