<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

    public function index()
    {
        $token = Session::get('accessToken');

        $response = Http::withToken($token)
            ->get(env('API_URL').'/usuarios');

        $usuarios = [];

        if ($response->status() == 200) {
            $usuarios = json_decode($response->body(), true);
        }

        return view('usuarios.index', compact('usuarios'));
    }

    public function store(Request $request)
    {

        $token = Session::get('accessToken');

        Http::withToken($token)->post(
            env('API_URL').'/usuarios',
            $request->all()
        );

        return redirect()->route('usuarios');
    }

    public function desactivar($id)
    {

        $token = Session::get('accessToken');

        Http::withToken($token)->put(
            env('API_URL')."/usuarios/$id/desactivar"
        );

        return redirect()->route('usuarios');
    }
}