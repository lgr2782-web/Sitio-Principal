@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
<h4>Productos</h4>

<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProducto">
<i class="bi bi-plus"></i> Nuevo
</button>
</div>

<table id="tablaProductos" class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Precio</th>
<th>Stock</th>
<th>Acciones</th>
</tr>
</thead>

<tbody></tbody>

</table>

@include('productos.modal')
 @include('productos.modal_editar') 

@endsection

@section('scripts')

<script>

let tabla;

document.addEventListener("DOMContentLoaded",()=>{

tabla = $('#tablaProductos').DataTable({

ajax:{
url:`${API_URL}/productos`,
headers:{ Authorization:`Bearer ${token}` },
dataSrc:""
},

columns:[

{data:"id_producto"},

{data:"descripcion"},

{
data:"precio_unitario",
render:(data)=>{
return "₡ " + Number(data).toLocaleString();
}
},

// 👇 STOCK (aunque no venga)
{
data:"stock",
render:(data)=>{
return Number(data).toLocaleString();
}
},

// 👇 ACCIONES
{
data:null,
render:(data)=>{
return `
<button class="btn btn-warning btn-sm" onclick='editar(${JSON.stringify(data)})'>
<i class="bi bi-pencil"></i>
</button>

<button class="btn btn-danger btn-sm" onclick='eliminar(${data.id_producto})'>
<i class="bi bi-trash"></i>
</button>
`;
}
}

]

});

});

function editar(producto){

// llenar modal
document.getElementById("edit_id").value = producto.id_producto;
document.getElementById("edit_codigo").value = producto.codigo;
document.getElementById("edit_descripcion").value = producto.descripcion;
document.getElementById("edit_precio").value = producto.precio_unitario;

// abrir modal
new bootstrap.Modal(document.getElementById('modalEditar')).show();

}

async function eliminar(id){

const confirmacion = await Swal.fire({
title: '¿Eliminar producto?',
text: 'Esta acción no se puede deshacer',
icon: 'warning',
showCancelButton: true,
confirmButtonText: 'Sí, eliminar',
cancelButtonText: 'Cancelar'
});

if(!confirmacion.isConfirmed) return;

try{

await axios.delete(`${API_URL}/productos/${id}`,{
headers:{ Authorization:`Bearer ${token}` }
});

// refrescar tabla
tabla.ajax.reload(null,false);

Swal.fire({
icon:"success",
title:"Eliminado",
timer:1500,
showConfirmButton:false
});

}catch(err){

console.error(err);

Swal.fire({
icon:"error",
title:"Error",
text:"No se pudo eliminar"
});

}

}

</script>

@endsection