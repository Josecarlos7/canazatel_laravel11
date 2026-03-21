<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DescuentoDias extends Model
{
    protected $table = 'descuento_dias';

    protected $primaryKey = 'ID_DD';

    public $timestamps = false;

    protected $guarded = [];
}
