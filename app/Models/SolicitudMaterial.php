<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudMaterial extends Model
{
    protected $table = 'solicitud_material';

    protected $primaryKey = 'ID_SM';

    protected $guarded = [];
}
