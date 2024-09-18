<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\CreateClientRequest;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::name($request->get('name'))->orderBy('name')->paginate(50);
        $phones = Phone::all();
        $title = 'Clientes';
        return view('clients.index', compact('title', 'clients', 'phones'));
    }

    public function create()
    {
        $title = 'Nuevo cliente';
        $clients = Client::all();
        return view('clients.create', compact('title', 'clients'));
    }

    public function edit(Client $client)
    {
        $title = 'Editar Cliente';
        $clients = Client::all();
        $users = User::all();
        $phones = Phone::all();

        return view('clients.edit', compact('title', 'client', 'clients', 'users', 'phones'));
    }

    public function store(CreateClientRequest $request)
    {
        $request->createClient();
        return redirect()->route('clients.index');
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'phones' => 'array|nullable'
        ], [
            'name.required' => 'Introdueix un nom per al client',
            'phone.required' => 'Introdueix un telèfon'
        ]);

        $client->update($data);

        // Manage phone records
        $phones = $request->input('phones', []);
        $client->phone()->delete(); // Remove all old phone records
        foreach ($phones as $phone) {
            $client->phone()->create(['phone' => $phone]);
        }

        // Update the main phone if it was not included in the new phones list
        if (!in_array($data['phone'], $phones)) {
            $client->phone()->create(['phone' => $data['phone']]);
        }

        return redirect()->route('clients.index');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index');
    }

    public function showImport()
    {
        $title = 'Importar clients desde xlsx';
        return view('clients.import', compact('title'));
    }

    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        Excel::import(new ClientsImport, $request->file('file'));

        return redirect()->route('clients.index')->with('success', 'Clients imported successfully');
    }
}

// Import class for handling the Excel import
//class ClientsImport implements ToCollection, WithHeadingRow
//{
//    use Importable;
//
//    public function collection(Collection $rows)
//    {
//        foreach ($rows as $row) {
//            // Skip if name is empty
//            if (empty($row['name'])) {
//                continue;
//            }
//
//            // Skip known duplicates
//            $excludedClients = [
//                "IES MONTSIA",
//                "FERRE ANDREU, MERCEDES",
//                "AJUNTAMENT DELTEBRE",
//                "PROJECTE PRINCIPAL, S.L.",
//                "VICENTE TALARN, VICTOR",
//                "ALIAU PONS, GABRIEL",
//                "BAYERRI BONANCIA, ALVARO",
//                "MARTINEZ FORNER, VICENT",
//                "MARCO PONS, OSCAR",
//                "AJUNTAMENT D'AMPOSTA",
//                "SOLER SUBIRATS, LAUREANO"
//            ];
//
//            if (in_array($row['name'], $excludedClients)) {
//                continue;
//            }
//
//            $client = Client::updateOrCreate(
//                ['name' => $row['name']], // Match on name
//                ['email' => $row['email']]
//            );
//
//            // Handle phones
//            $client->phone()->create(['phone' => $row['phone1']]);
//            if (!empty($row['phone2'])) {
//                $client->phone()->create(['phone' => $row['phone2']]);
//            }
//        }
//    }
//}

