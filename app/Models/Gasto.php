<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gasto';

    protected $primaryKey = 'ID_GAS';

    protected $guarded = [];
}
