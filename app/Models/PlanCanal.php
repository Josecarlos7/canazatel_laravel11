<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanCanal extends Model
{
    protected $table = 'plan_canal';

    protected $primaryKey = 'ID_PC';

    public $timestamps = false;

    protected $guarded = [];
}
