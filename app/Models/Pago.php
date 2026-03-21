<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pago';

    protected $primaryKey = 'ID_PAG';

    public $timestamps = false;

    protected $guarded = [];

    public function detalles()
    {
        return $this->hasMany(PagoDetalle::class, 'ID_PAG', 'ID_PAG');
    }

    public function otros()
    {
        return $this->hasMany(PagoOtro::class, 'ID_PAG', 'ID_PAG');
    }
}
