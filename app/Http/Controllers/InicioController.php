<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InicioController extends Controller
{
    public function index()
    {
        return view('inicio.index');
    }

    public function error()
    {
        return view('layouts.error');
    }

    public function password(Request $request)
    {
        $request->validate([
            'password_act' => ['required', 'string'],
            'password_new' => ['required', 'string', 'min:8'],
        ]);

        $usuario = User::find(Auth::id());

        if (! $usuario || ! Hash::check($request->password_act, $usuario->password)) {
            return back()->with('error', 'Error en la contraseña actual');
        }

        $usuario->password = Hash::make($request->password_new);
        $usuario->save();

        return back()->with('exito', 'Contraseña cambiada');
    }
}
