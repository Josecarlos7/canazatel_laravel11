<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    protected $table = 'canal';

    protected $primaryKey = 'ID_CAN';

    public $timestamps = false;

    protected $guarded = [];

    public static function validationStore($request): ?string
    {
        if (self::where('NOM_CAN', $request->nom_can)->exists()) {
            return 'Un canal con el nombre: '.$request->nom_can.' ya se encuentra registrado!';
        }

        return null;
    }
}
