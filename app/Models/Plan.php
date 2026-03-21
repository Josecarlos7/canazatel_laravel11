<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plan';

    protected $primaryKey = 'ID_PLAN';

    public $timestamps = false;

    protected $guarded = [];

    public static function validationStore($request): ?string
    {
        if (self::where('NOM_PLAN', $request->nom_plan)->exists()) {
            return 'Un plan con el nombre: '.$request->nom_plan.' ya se encuentra registrado!';
        }

        return null;
    }

    public function canales()
    {
        return $this->hasMany(PlanCanal::class, 'ID_PLAN', 'ID_PLAN')
            ->join('canal', 'canal.ID_CAN', '=', 'plan_canal.ID_CAN');
    }
}
