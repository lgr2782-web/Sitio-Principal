@extends('layouts.app')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between mb-3">
<h3>Inventario</h3>

<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInventario">
<i class="bi bi-plus"></i> Movimiento
</button>
</div>

<table id="tablaInventario" class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
<th>ID</th>
<th>Producto</th>
<th>Tipo</th>
<th>Cantidad</th>
<th>Fecha</th>
</tr>
</thead>

<tbody></tbody>

</table>

</div>

@include('inventario.modal')

@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>

let tabla;

function cargarInventario(){

if(tabla) tabla.destroy();

tabla = $('#tablaInventario').DataTable({

ajax:{
url:`${API_URL}/inventario`,
dataSrc:'',
headers:{ Authorization:`Bearer ${token}` }
},

columns:[
{data:'id_movimiento'},
{data:'descripcion'},
{data:'tipo'},
{data:'cantidad'},
{data:'fecha'}
],

language:{
url:'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
}

});

}

document.addEventListener("DOMContentLoaded",function(){
cargarInventario();
cargarProductos();
});

</script>

@endsection