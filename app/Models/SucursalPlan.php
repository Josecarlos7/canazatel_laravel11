<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SucursalPlan extends Model
{
    protected $table = 'sucursal_plan';

    protected $primaryKey = 'ID_SP';

    public $timestamps = false;

    protected $guarded = [];
}
