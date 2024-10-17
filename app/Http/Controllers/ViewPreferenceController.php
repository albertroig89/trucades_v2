<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewPreferenceController extends Controller
{
    public function changeViewPreference(Request $request)
    {
        // Validar que el valor de 'desktop' sea un booleano
        $request->validate([
            'desktop' => 'required|boolean',
        ]);

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Actualizar la preferencia de vista (escritorio o móvil)
        $user->desktop = $request->input('desktop');
        $user->save();

        // Redirigir a la página anterior
        return redirect()->back();
    }
}
