<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Client;
use App\Models\Phone;
use App\Models\Stat;
use App\Models\User;
use App\Http\Requests\CreateCallRequest;
use Illuminate\Http\Request;

class CallController extends Controller
{

    // Método para mostrar el formulario de creación de llamada
    public function create()
    {
        $title = 'Nueva llamada';
        $clients = Client::all();
        $users = User::all();
        $stats = Stat::all();
        $nStat = Stat::where('title', 'Normal')->value('id');

        return view('calls.create', compact('title', 'clients', 'users', 'stats', 'nStat'));
    }

    // Método para mostrar el formulario de creación de trabajo desde una llamada
    public function jobfromcall(Call $call)
    {
        $clients = Client::all();
        $users = User::all();
        $stats = Stat::all();
        $phones = Phone::all();

        return view('calls.jobfromcall', compact('call', 'clients', 'users', 'stats', 'phones'));
    }

    // Método para mostrar el formulario de edición de llamada
    public function edit(Call $call)
    {
        $title = 'Editar llamada';
        $clients = Client::all();
        $users = User::all();
        $stats = Stat::all();

        return view('calls.edit', compact('title', 'call', 'clients', 'users', 'stats'));
    }

    // Método para almacenar una nueva llamada
    public function store(CreateCallRequest $request)
    {
        $request->createCall();
        return redirect()->route('dashboard');
    }

    // Método para actualizar una llamada existente
    public function update(Request $request, Call $call)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'client_id' => 'nullable',
            'stat_id' => 'required',
            'callinf' => 'required',
            'clientname' => 'required',
            'clientphone' => 'nullable',
        ], [
            'user_id.required' => 'Selecciona un empleado',
            'clientname.required' => 'Selecciona un cliente o escribe uno',
            'stat_id.required' => 'Selecciona un estado',
            'callinf.required' => 'Rellena la información de la llamada'
        ]);

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

    // Método para eliminar una llamada existente
    public function destroy(Call $call)
    {
        $call->delete();
        return redirect()->route('dashboard');
    }
}

