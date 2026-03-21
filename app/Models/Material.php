<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'material';

    protected $primaryKey = 'ID_MAT';

    protected $guarded = [];

    public static function validationStore($request): ?string
    {
        if (self::where('NOM_MAT', $request->nom_mat)->exists()) {
            return 'Un Material con el nombre: '.$request->nom_mat.' ya se encuentra registrado!';
        }

        return null;
    }
}
