<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamo extends Model
{
    protected $table = 'reclamo';

    protected $primaryKey = 'ID_REC';

    public $timestamps = false;

    protected $guarded = [];
}
