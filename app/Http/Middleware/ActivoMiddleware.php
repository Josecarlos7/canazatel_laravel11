<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ActivoMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (int) Auth::user()->EST_USU === 0) {
            Auth::logout();

            return redirect('/login')->with(
                'mensaje',
                'USTED NO PUEDE INGRESAR AL SISTEMA, CONTACTESE CON EL ADMINISTRADOR'
            );
        }

        return $next($request);
    }
}
