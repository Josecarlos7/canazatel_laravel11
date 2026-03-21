<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursal';

    protected $primaryKey = 'ID_SUC';

    public $timestamps = false;

    protected $guarded = [];

    public static function validationStore($request): ?string
    {
        if (self::where('NOM_SUC', $request->nom_suc)->exists()) {
            return 'Una sucursal con el nombre: '.$request->nom_suc.' ya se encuentra registrada!';
        }

        return null;
    }

    public function planes()
    {
        return $this->hasMany(SucursalPlan::class, 'ID_SUC', 'ID_SUC')
            ->join('plan', 'plan.ID_PLAN', '=', 'sucursal_plan.ID_PLAN');
    }
}
