<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthRole
{
    /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */

    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $user = $request->user();
        $url = $request->url();
        
        if (!$user->roles()->exists()) { // Verificar si el usuario no tiene ningún rol asignado
            return redirect()->route('client.create');
        }
        if (!$user->client) { // Verificar si el usuario no tiene un cliente creado
            return redirect()->route('client.create');
        }

        // error_log(print_r($url, true));
        // error_log(print_r($user, true));

        foreach ($permissions as $permission) {
            // error_log($permission);
            if ($user->hasAnyPermission($permission)) {
                return $next($request);
            }
        }
        abort(403, 'No tienes permisos para acceder a esta página.');
    }
}
