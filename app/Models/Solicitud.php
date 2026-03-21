<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitud';

    protected $primaryKey = 'ID_SOL';

    protected $guarded = [];

    public function detalles()
    {
        return $this->hasMany(SolicitudMaterial::class, 'ID_SOL', 'ID_SOL')
            ->join('material', 'material.ID_MAT', '=', 'solicitud_material.ID_MAT');
    }
}
