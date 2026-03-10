@extends('layouts.app')

@section('content')

<div class="container-fluid">

<div class="card">

<div class="card-header">
<h4>Datos de la Empresa</h4>
</div>

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">
<label>Nombre Comercial</label>
<input type="text" id="nombre_comercial" class="form-control">
</div>

<div class="col-md-6 mb-3">
<label>Razón Social</label>
<input type="text" id="razon_social" class="form-control">
</div>

<div class="col-md-6 mb-3">
<label>Cédula Jurídica</label>
<input type="text" id="cedula_juridica" class="form-control">
</div>

<div class="col-md-6 mb-3">
<label>Email</label>
<input type="email" id="email" class="form-control">
</div>

<div class="col-md-6 mb-3">
<label>Teléfono</label>
<input type="text" id="telefono" class="form-control">
</div>

<div class="col-md-12 mb-3">
<label>Dirección</label>
<textarea id="direccion" class="form-control"></textarea>
</div>

<div class="col-md-12">

<button class="btn btn-primary" onclick="guardarEmpresa()">
<i class="bi bi-save"></i> Guardar
</button>

</div>

</div>

</div>

</div>

</div>

@endsection



@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>

const API = `${window.API_URL}/empresas`;


async function cargarEmpresa(){

try{

const res = await axios.get(`${window.API_URL}/empresas/mi-empresa`,{
headers:{
Authorization:`Bearer ${window.token}`
}
});

const empresa = res.data;

document.getElementById("nombre_comercial").value = empresa.nombre_comercial || "";
document.getElementById("razon_social").value = empresa.razon_social || "";
document.getElementById("cedula_juridica").value = empresa.cedula_juridica || "";
document.getElementById("email").value = empresa.email || "";
document.getElementById("telefono").value = empresa.telefono || "";
document.getElementById("direccion").value = empresa.direccion || "";

}catch(error){

console.error(error);

}

}



async function guardarEmpresa(){

try{

await axios.put(`${API}/mi-empresa`,{

nombre_comercial:document.getElementById("nombre_comercial").value,
razon_social:document.getElementById("razon_social").value,
cedula_juridica:document.getElementById("cedula_juridica").value,
email:document.getElementById("email").value,
telefono:document.getElementById("telefono").value,
direccion:document.getElementById("direccion").value

},{
headers:{ Authorization:`Bearer ${token}` }
})

Swal.fire({
icon:"success",
title:"Empresa actualizada",
timer:1500,
showConfirmButton:false
})

}catch(error){

Swal.fire("Error","No se pudo guardar","error")

}

}



document.addEventListener("DOMContentLoaded",function(){
cargarEmpresa()
})

</script>

@endsection