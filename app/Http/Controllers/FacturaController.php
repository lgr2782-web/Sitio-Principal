<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FacturaController extends Controller
{
    public function index()
    {
        $token = session('accessToken');

        if (!$token) {
            return redirect()->route('login');
        }

        $response = Http::withToken($token)
            ->get(env('API_URL') . '/facturas/consecutivo');

        $data = $response->json();

        return view('facturas.index', [
            'numeroConsecutivo' => $data['numeroConsecutivo'] ?? ''
        ]);
    }

    public function store(Request $request)
    {
        $token = session('accessToken');

        if (!$token) {
            return response()->json([
                'message' => 'Sesión expirada'
            ], 401);
        }

        $response = Http::withToken($token)
            ->post(
                env('API_URL') . '/facturas',
                $request->all()
            );

        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function clientes(Request $request)
{
    $token = session('accessToken');

    $response = Http::withToken($token)
        ->get(env('API_URL') . '/facturas/clientes', [
            'q' => $request->q
        ]);

    return response()->json($response->json(), $response->status());
}

public function productos(Request $request)
{
    $token = session('accessToken');

    $response = Http::withToken($token)
        ->get(env('API_URL') . '/facturas/productos', [
            'q' => $request->q
        ]);

    return response()->json($response->json(), $response->status());
}
}