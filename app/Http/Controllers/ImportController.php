<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Imports\ClientsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * Importa clientes desde un archivo Excel.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        // Cambia 'clients.xlsx' por la ruta a tu archivo o recibe el archivo a través de un request
        $filePath = storage_path('app/public/clients.xlsx');

        // Realiza la importación usando el importador
        Excel::import(new ClientsImport, $filePath);

        // Retorna toda la información de la tabla para verificar las inserciones
        return Client::all();
    }
}

