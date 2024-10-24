<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Http\Requests\CreateClientRequest;
use App\Models\Phone;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        if ($request->ajax()) {
            if ($request->has('search') && !empty($request->get('search'))) {
                $query->where('name', 'like', '%' . $request->get('search') . '%');
            }
            $clients = $query->orderBy('name')->paginate(50);
            $phones = Phone::all();

            // Obtener la preferencia de vista desde la solicitud (index o cards)
            $viewType = $request->get('viewType', 'clientstable');

            return response()->json([
                'html' => view("clients.partials.$viewType", compact('clients', 'phones'))->render(),
            ]);
        }

        // Obtener la preferencia de vista desde la solicitud (index o cards)
        $viewType = $request->get('viewType', 'index');

        $clients = $query->orderBy('name')->paginate(50);
        $phones = Phone::all();
        $title = 'Clientes';
        return view("clients.$viewType", compact('title', 'clients', 'phones'));
    }

    public function create()
    {
        $title = 'Nuevo cliente';
        return view('clients.create', compact('title'));
    }

    public function edit(Client $client)
    {
        $title = 'Editar Cliente';
        $phones = $client->phones;

        return view('clients.edit', compact('title', 'client', 'phones'));
    }

    public function store(CreateClientRequest $request)
    {
        $request->createClient();
        return redirect()->route('clients.index');
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $request->updateClient($client);
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

