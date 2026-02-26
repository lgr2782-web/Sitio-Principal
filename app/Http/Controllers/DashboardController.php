<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Session::has('accessToken')) {
            return redirect()->route('login');
        }

        $client = new Client();

        try {
            $response = $client->get(env('API_URL') . '/dashboard/resumen', [
                'headers' => [
                    'Authorization' => 'Bearer ' . Session::get('accessToken'),
                    'Accept' => 'application/json',
                ]
            ]);

            $resumen = json_decode($response->getBody()->getContents(), true);

        } catch (\Exception $e) {
            $resumen = [
                'productos' => 0,
                'clientes' => 0,
                'facturas_hoy' => 0,
                'ventas_hoy' => 0,
                'total_facturas' => 0
            ];
        }

        return view('dashboard', compact('resumen'));
    }
}
