<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudWeb extends Model
{
    protected $table = 'solicitud_web';

    protected $primaryKey = 'ID_SW';

    public $timestamps = false;

    protected $guarded = [];
}
