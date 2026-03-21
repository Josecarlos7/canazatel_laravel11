<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $table = 'convenio';

    protected $primaryKey = 'ID_CVN';

    public $timestamps = false;

    protected $guarded = [];
}
