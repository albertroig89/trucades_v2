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
            $viewType = $user->desktop ? 'index' : 'mobile-index';

            // Agregar la preferencia de vista a la solicitud
            $request->attributes->set('viewType', $viewType);
        }

        return $next($request);
    }
}




