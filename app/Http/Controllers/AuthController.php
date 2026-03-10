<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $response = Http::post(env('API_URL') . '/auth/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Credenciales incorrectas
        if ($response->failed()) {
            return back()->with('error', 'Credenciales incorrectas');
        }

        $data = $response->json();

        // Guardar token
        Session::put('accessToken', $data['accessToken']);

        // Guardar usuario
        Session::put('usuario', $data['usuario']);

        // Guardar expiración del token (segundos)
        Session::put('tokenExpire', time() + $data['exp']);

        return redirect()->route('dashboard');

    }


    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}