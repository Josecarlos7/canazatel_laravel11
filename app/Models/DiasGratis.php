<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiasGratis extends Model
{
    protected $table = 'dias_gratis';

    protected $primaryKey = 'ID_DG';

    public $timestamps = false;

    protected $guarded = [];
}
