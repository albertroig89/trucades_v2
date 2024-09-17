<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Department;
use App\Models\Phone;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return View|Factory|Application
     */
    public function index(Request $request): View|Factory|Application
    {
        $title = 'Llamadas';
        $users = User::all();
        $phones = Phone::all();
        $techId = Department::where('title', 'Tecnico')->value('id');
        $admId = Department::where('title', 'Administración')->value('id');
        $globId = Department::where('title', 'Global')->value('id');
        $nStat = Stat::where('title', 'Normal')->value('id');
        $uStat = Stat::where('title', 'Urgente')->value('id');
        $pStat = Stat::where('title', 'Pendiente')->value('id');

        $globalId = User::where('name', 'Global')->value('id');

        $allcalls = false;

        // Lógica para determinar el usuario actual y llamadas relevantes
        if (!empty($request->get('user_id')) && $request->get('user_id') == "100") {
            $allcalls = true;
            $userid = auth()->id();
            $user = User::find($userid);
        } elseif (empty($request->get('user_id'))) {
            $userid = auth()->id();
            $user = User::find($userid);
        } else {
            $userid = $request->get('user_id');
            $user = User::find($userid);
        }

        // Determinar las llamadas basadas en el departamento del usuario y el ID de usuario
        if (empty($request->get('user_id')) && auth()->user()->department_id === $techId) {
            $calls = Call::whereIn('user_id', [auth()->id(), $globalId])
                ->orderBy('user_id', 'DESC')
                ->orderBy('stat_id')
                ->orderBy('created_at', 'DESC')
                ->paginate(50);
        } elseif (empty($request->get('user_id')) && auth()->user()->department_id === $admId) {
            $calls = Call::orderBy('created_at', 'DESC')->paginate(20);
            $allcalls = true;
        } elseif (empty($request->get('user_id'))) {
            $calls = Call::where('user_id', auth()->id())
                ->orderBy('stat_id')
                ->orderBy('created_at', 'DESC')
                ->paginate(50);
        } elseif ($request->get('user_id') == "100") {
            $calls = Call::orderBy('created_at', 'DESC')->paginate(100);
        } else {
            $calls = Call::where('user_id', $request->get('user_id'))
                ->orderBy('stat_id')
                ->orderBy('created_at', 'DESC')
                ->paginate(50);
        }

        // Verificar la preferencia del usuario (escritorio o móvil)
        $view = auth()->user()->desktop ? 'dashboard' : 'mobile-dashboard';

        // Retorna la vista correspondiente
        return view($view, compact('title', 'calls', 'users', 'phones', 'techId', 'globId', 'nStat', 'uStat', 'pStat', 'user', 'allcalls'));
    }


    public function changeViewPreference(Request $request)
    {
        \Log::info('Valor recibido para desktop: ' . $request->input('desktop'));

        // Validar que el valor de desktop sea un booleano
        $request->validate([
            'desktop' => 'required|boolean',
        ]);

        // Obtener el usuario autenticado
        $user = auth()->user();

        \Log::info('Valor de desktop antes de guardar: ' . $user->desktop);

        // Actualizar la preferencia de la vista
        $user->desktop = $request->input('desktop');
        $user->save();

        \Log::info('Valor de desktop después de guardar: ' . $user->desktop);

        // Redirigir a la ruta 'dashboard' para que determine la vista adecuada
        return redirect()->route('dashboard');
    }
}

