<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCallRequest;
use App\Models\Call;
use App\Models\Client;
use App\Models\Department;
use App\Models\Phone;
use App\Models\Stat;
use App\Models\User;
use App\Http\Requests\CreateCallRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CallController extends Controller
{








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
        $view = auth()->user()->desktop ? 'calls.index' : 'calls.mobile-index';

        // Retorna la vista correspondiente
        return view($view, compact('title', 'calls', 'users', 'phones', 'techId', 'globId', 'nStat', 'uStat', 'pStat', 'user', 'allcalls'));
    }


    public function changeViewPreference(Request $request)
    {
        // Validar que el valor de desktop sea un booleano
        $request->validate([
            'desktop' => 'required|boolean',
        ]);

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Actualizar la preferencia de la vista
        $user->desktop = $request->input('desktop');
        $user->save();

        // Redirigir a la ruta 'dashboard' para que determine la vista adecuada
        return redirect()->route('calls.index');
    }








    // Metodo para mostrar el formulario de creación de llamada
    public function create()
    {
        $title = 'Nueva llamada';
        $clients = Client::all();
        $users = User::all();
        $stats = Stat::all();
        $nStat = Stat::where('title', 'Normal')->value('id');

        return view('calls.create', compact('title', 'clients', 'users', 'stats', 'nStat'));
    }

    // Metodo para mostrar el formulario de edición de llamada
    public function edit(Call $call)
    {
        $title = 'Editar llamada';
        $clients = Client::all();
        $users = User::all();
        $stats = Stat::all();

        return view('calls.edit', compact('title', 'call', 'clients', 'users', 'stats'));
    }

    // Metodo para almacenar una nueva llamada
    public function store(CreateCallRequest $request)
    {
        $request->createCall();
        return redirect()->route('dashboard');
    }


    // Metodo para actualizar una llamada existente
    public function update(UpdateCallRequest $request, Call $call)
    {
        // Obtenemos los datos validados del request
        $data = $request->validated();

        // Actualizamos el modelo
        $call->update([
            'user_id' => $data['user_id'],
            'client_id' => $data['client_id'] ?? null,
            'user_id2' => auth()->id(),  // Asignamos el ID del usuario autenticado
            'stat_id' => $data['stat_id'],
            'callinf' => $data['callinf'],
            'clientname' => $data['clientname'],
            'clientphone' => $data['clientphone'] ?? null,
        ]);

        return redirect()->route('dashboard');
    }

    // Metodo para eliminar una llamada existente
    public function destroy(Call $call)
    {
        $call->delete();
        return redirect()->route('dashboard');
    }
}

