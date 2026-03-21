<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoOtro extends Model
{
    protected $table = 'pago_otro';

    protected $primaryKey = 'ID_PO';

    public $timestamps = false;

    protected $guarded = [];
}
