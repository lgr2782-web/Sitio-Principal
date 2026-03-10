@extends('layouts.app')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between mb-3">

<h3>Empresas</h3>

</div>

<table id="tablaEmpresas" class="table table-bordered table-striped">

<thead class="table-dark">

<tr>
<th>ID</th>
<th>Nombre Comercial</th>
<th>Razón Social</th>
<th>Cédula Jurídica</th>
<th>Email</th>
<th>Teléfono</th>
</tr>

</thead>

<tbody></tbody>

</table>

</div>

@endsection



@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>

const API = "{{ env('API_URL') }}/empresa";
const token = "{{ session('accessToken') }}";

let tabla=null;


async function cargarEmpresas(){

try{

const res = await axios.get(API,{
headers:{ Authorization:`Bearer ${token}` }
})

let html=""

res.data.forEach(e=>{

html+=`

<tr>

<td>${e.id_empresa}</td>
<td>${e.nombre_comercial}</td>
<td>${e.razon_social}</td>
<td>${e.cedula_juridica}</td>
<td>${e.email}</td>
<td>${e.telefono}</td>

</tr>

`

})

document.querySelector("#tablaEmpresas tbody").innerHTML=html

activarTabla()

}catch(error){

console.error(error)

}

}



function activarTabla(){

if(tabla){
tabla.destroy()
}

tabla = $('#tablaEmpresas').DataTable({

pageLength:10,

language:{
url:'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
}

})

}



document.addEventListener("DOMContentLoaded",function(){

cargarEmpresas()

})

</script>

@endsection