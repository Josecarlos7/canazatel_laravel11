<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermisoController extends Controller
{
    public function index()
    {
        $permisos = Permission::orderBy('name')->get();

        return view('permiso.index', compact('permisos'));
    }

    public function create()
    {
        return redirect()->route('permiso.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('permiso.index');
    }

    public function show(string $id)
    {
        return redirect()->route('permiso.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('permiso.index');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('permiso.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('permiso.index');
    }
}
