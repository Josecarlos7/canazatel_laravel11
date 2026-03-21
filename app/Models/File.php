<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'file';

    protected $primaryKey = 'ID_FILE';

    public $timestamps = false;

    protected $guarded = [];
}
