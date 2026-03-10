<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard')</title>


<!-- Bootstrap + Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">



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
<script>

    window.API_URL = "{{ env('API_URL') }}";
    window.token = "{{ session('accessToken') }}";
    window.tokenExpire = {{ session('tokenExpire') ?? 0 }};

</script>

<script>

function iniciarControlSesion(){

if(!window.tokenExpire) return;

const ahora = Math.floor(Date.now()/1000);
const tiempoRestante = window.tokenExpire - ahora;

console.log("Segundos restantes:", tiempoRestante);

/* Mostrar alerta 10 segundos antes */

if(tiempoRestante > 10){

setTimeout(mostrarAviso,(tiempoRestante-10)*1000);

}else{

mostrarAviso();

}

}



function mostrarAviso(){

Swal.fire({

title:'Sesión por expirar',
text:'Tu sesión termina en 10 segundos ¿deseas continuar?',
icon:'warning',
showCancelButton:true,
confirmButtonText:'Renovar sesión',
cancelButtonText:'Cerrar sesión',
allowOutsideClick:false

}).then((result)=>{

if(result.isConfirmed){

renovarToken();

}else{

cerrarSesion();

}

})

}



async function renovarToken(){

try{

const res = await axios.post(`${API_URL}/auth/refresh`,{},{

headers:{ Authorization:`Bearer ${window.token}` },
withCredentials:true

});

location.reload();

}catch(error){

cerrarSesion();

}

}

function cerrarSesion(){
    fetch("{{ route('logout') }}",{
    method:"POST",
    headers:{
    "X-CSRF-TOKEN":"{{ csrf_token() }}",
    "Content-Type":"application/json"
    }
    }).then(()=>{
    window.location.href="/login";
    });
}

document.addEventListener("DOMContentLoaded",function(){

iniciarControlSesion();

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield('scripts')
</body>
</html>