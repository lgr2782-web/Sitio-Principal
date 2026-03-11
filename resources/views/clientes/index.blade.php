@extends('layouts.app')

@section('title','Clientes')

@section('content')

<div class="d-flex justify-content-between mb-3">

<h4>Clientes</h4>

<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCliente">
<i class="bi bi-plus"></i> Nuevo Cliente
</button>

</div>

<table id="tablaClientes" class="table table-bordered table-striped">

<thead>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Identificación</th>
<th>Email</th>
<th>Teléfono</th>
<th>Acciones</th>
</tr>
</thead>

<tbody></tbody>

</table>

@include('clientes.modal')
@include('clientes.modal_editar')

@endsection
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

@yield('scripts')

@section('scripts')

<script>

let tabla;

document.addEventListener("DOMContentLoaded",()=>{

tabla = $('#tablaClientes').DataTable({

ajax:{
url:`${API_URL}/clientes`,
headers:{ Authorization:`Bearer ${token}` },
dataSrc:""
},

columns:[

{data:"id_cliente"},
{data:"nombre"},
{data:"identificacion"},
{data:"email"},
{data:"telefono"},

{
data:null,
render:function(data){

return `

<button class="btn btn-warning btn-sm" onclick='editarCliente(${JSON.stringify(data)})'>
<i class="bi bi-pencil"></i>
</button>

<button class="btn btn-danger btn-sm" onclick='eliminarCliente(${data.id_cliente})'>
<i class="bi bi-trash"></i>
</button>

`;

}
}

]

});

});

</script>

@endsection