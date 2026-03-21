<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoDetalle extends Model
{
    protected $table = 'pago_detalle';

    protected $primaryKey = 'ID_PD';

    public $timestamps = false;

    protected $guarded = [];
}
