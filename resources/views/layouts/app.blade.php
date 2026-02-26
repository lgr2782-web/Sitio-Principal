<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard')</title>


<!-- Bootstrap + Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


<!-- App CSS -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="d-flex" id="app">


@include('partials.sidebar')


<div class="flex-grow-1 main">
@include('partials.navbar')


<main class="p-4">
@yield('content')
</main>


@include('partials.footer')
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
document.getElementById('sidebar').classList.toggle('collapsed');
}
</script>
</body>
</html>