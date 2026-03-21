<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuracion';

    protected $primaryKey = 'ID_CNF';

    public $timestamps = false;

    protected $guarded = [];
}
