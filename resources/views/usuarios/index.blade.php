@extends('layouts.app')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between mb-3">

<h3>Usuarios</h3>

<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUsuario">
<i class="bi bi-person-plus"></i> Nuevo Usuario
</button>

</div>


<table id="tablaUsuarios" class="table table-bordered table-striped">

<thead class="table-dark">

<tr>
<th>ID</th>
<th>Nombre</th>
<th>Email</th>
<th>Rol</th>
<th>Activo</th>
<th>Acciones</th>
</tr>

</thead>

<tbody></tbody>

</table>

</div>

@include('usuarios.modal')
@include('usuarios.modal_editar')

@endsection



@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>

const API = "{{ env('API_URL') }}/usuarios";
const token = "{{ session('accessToken') }}";

let tabla = null;



async function cargarUsuarios(){

try{

const res = await axios.get(API,{
headers:{ Authorization:`Bearer ${token}` }
})

let html=""

res.data.forEach(u=>{

html+=`

<tr>

<td>${u.id_usuario}</td>

<td>${u.nombre}</td>

<td>${u.email}</td>

<td>${u.rol}</td>

<td>

<div class="form-check form-switch">

<input class="form-check-input"
type="checkbox"
${u.activo==='A'?'checked':''}

onclick="toggleUsuario(${u.id_usuario},this.checked)">

</div>

</td>

<td>

<button class="btn btn-warning btn-sm"
onclick="abrirEditar(${u.id_usuario},'${u.nombre}','${u.email}','${u.rol}')">

<i class="bi bi-pencil"></i>

</button>

</td>

</tr>

`

})

document.querySelector("#tablaUsuarios tbody").innerHTML=html

activarTabla()

}catch(error){

console.error(error)

}

}



function activarTabla(){

if(tabla){
tabla.destroy()
}

tabla=$('#tablaUsuarios').DataTable({

pageLength:10,

language:{
url:'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
}

})

}



async function crearUsuario(){

try{

await axios.post(API,{

nombre:document.getElementById("nombre").value,
email:document.getElementById("email").value,
password:document.getElementById("password").value,
rol:document.getElementById("rol").value

},{
headers:{ Authorization:`Bearer ${token}`}
})

Swal.fire({
icon:'success',
title:'Usuario creado',
timer:1500,
showConfirmButton:false
})

bootstrap.Modal.getInstance(
document.getElementById('modalUsuario')
).hide()

cargarUsuarios()

}catch(error){

Swal.fire('Error','No se pudo crear','error')

}

}



async function toggleUsuario(id,activo){

let url = activo
? `${API}/${id}/activar`
: `${API}/${id}/desactivar`

try{

await axios.put(url,{},{
headers:{ Authorization:`Bearer ${token}`}
})

Swal.fire({
icon:'success',
title:'Usuario actualizado',
timer:1200,
showConfirmButton:false
})

}catch(error){

Swal.fire('Error','No se pudo actualizar','error')

}

}



function abrirEditar(id,nombre,email,rol){

document.getElementById("edit_id").value=id
document.getElementById("edit_nombre").value=nombre
document.getElementById("edit_email").value=email
document.getElementById("edit_rol").value=rol

new bootstrap.Modal(
document.getElementById('modalEditar')
).show()

}



async function guardarEdicion(){

let id=document.getElementById("edit_id").value

try{

await axios.put(`${API}/${id}`,{

nombre:document.getElementById("edit_nombre").value,
email:document.getElementById("edit_email").value,
rol:document.getElementById("edit_rol").value

},{
headers:{ Authorization:`Bearer ${token}`}
})

Swal.fire({
icon:'success',
title:'Usuario actualizado',
timer:1500,
showConfirmButton:false
})

bootstrap.Modal.getInstance(
document.getElementById('modalEditar')
).hide()

cargarUsuarios()

}catch(error){

Swal.fire('Error','No se pudo actualizar','error')

}

}



document.addEventListener("DOMContentLoaded",function(){
cargarUsuarios()
})

</script>

@endsection