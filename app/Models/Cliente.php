<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';

    protected $primaryKey = 'ID_CLI';

    public $timestamps = false;

    protected $guarded = [];

    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'ID_CLI', 'ID_CLI');
    }
}
