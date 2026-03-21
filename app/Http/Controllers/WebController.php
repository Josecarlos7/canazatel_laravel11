<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    public function index()
    {
        $sucursales = $this->cargarSucursales();

        return view('web.index', compact('sucursales'));
    }

    private function cargarSucursales(): Collection
    {
        try {
            return DB::table('sucursal')->orderBy('NOM_SUC', 'ASC')->get();
        } catch (\Throwable $e) {
            // Mientras se completa la migracion de tablas/modelos, la web publica debe seguir cargando.
            return collect();
        }
    }
}
