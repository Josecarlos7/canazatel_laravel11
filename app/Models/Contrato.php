<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'contrato';

    protected $primaryKey = 'ID_CON';

    public $timestamps = false;

    protected $guarded = [];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'ID_CLI', 'ID_CLI');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'ID_PLAN', 'ID_PLAN');
    }

    public function convenio()
    {
        return $this->hasMany(Convenio::class, 'ID_CON', 'ID_CON');
    }
}
