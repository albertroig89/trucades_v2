<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ViewPreferenceMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $routeName = $request->route()->getName();
            $viewBase = explode('.', $routeName);
            $viewName = end($viewBase); // Esto debe devolver "index", "histjobs", etc.

            // Ajustar el nombre de la vista para la preferencia de escritorio o móvil
            if ($viewName === 'histjobs') {
                // Si la vista es "histjobs", determinar si es escritorio o móvil
                $viewType = $user->desktop ? 'histjobs' : 'mobile-histjobs';
            } else {
                // Para todas las demás vistas
                $viewType = $user->desktop ? $viewName : "mobile-$viewName";
            }

            // Establecer la preferencia de vista
            $request->attributes->set('viewType', $viewType);
        }

        return $next($request);
    }
}




