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

        // Si falla login
        if ($response->failed()) {
            return back()->with('error', 'Credenciales incorrectas');
        }

        $data = $response->json();

        // Guardar access token
        Session::put('accessToken', $data['accessToken']);

        // Guardar usuario
        Session::put('usuario', $data['usuario']);

        // Guardar expiración
        Session::put('tokenExpire', time() + $data['exp']);

        /*
        Reenviar EXACTAMENTE la cookie original
        que devuelve Node (refreshToken)
        SIN recrearla para que Laravel no la cifre
        */
        $setCookie = $response->header('set-cookie');

        preg_match('/refreshToken=([^;]+)/', $setCookie, $matches);

        $refreshToken = $matches[1] ?? null;

        Session::put('refreshToken', $refreshToken);
        Session::save();

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Session::flush();

        return redirect()->route('login')
            ->withCookie(cookie()->forget('refreshToken'));
    }
}