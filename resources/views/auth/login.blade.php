<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('icono.png') }}">
    <title>Login | FacturaAPI</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #fff;
            width: 360px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 5px;
            color: #333;
        }

        .login-card p {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-size: 13px;
            color: #555;
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #2a5298;
        }

        .btn-login {
            width: 100%;
            background: #2a5298;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background: #1e3c72;
        }

        .error {
            background: #ffe5e5;
            color: #b30000;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 13px;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>

<div class="login-card">

    <h2>FacturaAPI</h2>
    <p>Acceso al sistema</p>

    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required autofocus>
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required>
        </div>

        <button class="btn-login" type="submit">
            Ingresar
        </button>
    </form>

    <div class="footer">
        © {{ date('Y') }} FacturaAPI
    </div>

</div>

</body>
</html>
