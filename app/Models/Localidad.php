<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'localidad';

    protected $primaryKey = 'ID_LOC';

    public $timestamps = false;

    protected $guarded = [];

    public static function validationStore($request): ?string
    {
        if (self::where('NOM_LOC', $request->nom_loc)->exists()) {
            return 'Una localidad con el nombre: '.$request->nom_loc.' ya se encuentra registrada!';
        }

        return null;
    }
}
