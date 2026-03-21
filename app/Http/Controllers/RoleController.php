<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')
            ->orderBy('name', 'asc')
            ->where('id', '<>', 4)
            ->get();

        $permisos = Permission::orderBy('name')->get();

        return view('rol.index', compact('roles', 'permisos'));
    }

    public function update(Request $request)
    {
        $rol = Role::where('id', $request->id_rol)->firstOrFail();
        $rol->syncPermissions($request->permisos ?? []);

        return redirect()->back()->with('exito', 'El ROL se ACTUALIZO exitosamente!');
    }

    public function busca(Request $request)
    {
        $rol = Role::with('permissions')->findOrFail($request->id_rol);

        return response()->json($rol);
    }

    public function create()
    {
        return redirect()->route('rol.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('rol.index');
    }

    public function show(string $id)
    {
        return redirect()->route('rol.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('rol.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('rol.index');
    }
}
