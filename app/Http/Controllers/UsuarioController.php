<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index()
    {
        $activos = User::with(['roles', 'sucursal'])
            ->where('EST_USU', 1)
            ->where('ID_USU', '<>', 1)
            ->get();

        $inactivos = User::with('roles')
            ->where('EST_USU', 0)
            ->get();

        $roles = Role::orderBy('name', 'asc')
            ->where('id', '<>', 4)
            ->get();

        $sucursales = Sucursal::all();

        return view('usuario.index', compact('activos', 'inactivos', 'roles', 'sucursales'));
    }

    public function store(Request $request)
    {
        $v = User::validationStore($request);
        if ($v) {
            return redirect()->back()->with('error', $v)->withInput();
        }

        $usuario = new User();
        $usuario->NOM_USU = $request->nom_usu;
        $usuario->PAT_USU = $request->pat_usu;
        $usuario->MAT_USU = $request->mat_usu;
        $usuario->CI_USU = $request->ci_usu;
        $usuario->EXP_USU = $request->exp_usu;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->EST_USU = 1;

        if ($request->id_suc) {
            $usuario->ID_SUC = $request->id_suc;
        }

        $usuario->save();

        $rol = Role::find($request->id_rol);
        if ($rol) {
            $usuario->assignRole($rol);
        }

        return redirect()->back()->with('exito', 'Usuario registrado');
    }

    public function actualiza(Request $request)
    {
        if ((int) $request->id_usu === 1) {
            return redirect()->back()->with('error', 'No puede editar a este usuario');
        }

        $usuario = User::findOrFail($request->id_usu);
        $usuario->NOM_USU = $request->nom_usu;
        $usuario->PAT_USU = $request->pat_usu;
        $usuario->MAT_USU = $request->mat_usu;
        $usuario->CI_USU = $request->ci_usu;
        $usuario->EXP_USU = $request->exp_usu;
        $usuario->email = $request->email;

        if ($request->password) {
            $usuario->password = bcrypt($request->password);
        }

        if ($request->id_suc) {
            $usuario->ID_SUC = $request->id_suc;
        }

        if ((int) $request->id_rol === 1) {
            $usuario->ID_SUC = null;
        }

        $usuario->save();
        $usuario->syncRoles([]);

        $rol = Role::find($request->id_rol);
        if ($rol) {
            $usuario->assignRole($rol);
        }

        return redirect()->back()->with('exito', 'Usuario editado');
    }

    public function elimina(Request $request)
    {
        if ((int) $request->id_usu === 1) {
            return redirect()->back()->with('error', 'No puede eliminar a este usuario');
        }

        $usuario = User::findOrFail($request->id_usu);
        $usuario->EST_USU = 0;
        $usuario->save();

        return redirect()->back()->with('exito', 'USUARIO inhabilitado exitosamente');
    }

    public function reactiva(Request $request)
    {
        $usuario = User::findOrFail($request->id_usu);
        $usuario->EST_USU = 1;
        $usuario->save();

        return redirect()->back()->with('exito', 'USUARIO reactivado exitosamente');
    }

    public function create()
    {
        return redirect()->route('usuario.index');
    }

    public function show(string $id)
    {
        return redirect()->route('usuario.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('usuario.index');
    }

    public function update(Request $request, string $id)
    {
        return $this->actualiza($request);
    }

    public function destroy(string $id)
    {
        return redirect()->route('usuario.index');
    }
}
