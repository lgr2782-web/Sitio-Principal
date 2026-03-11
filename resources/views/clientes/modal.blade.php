<div class="modal fade" id="modalCliente">

<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5>Nuevo Cliente</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<form id="formCliente">

<div class="mb-2">
<label>Nombre</label>
<input type="text" id="nombre" class="form-control">
</div>

<div class="mb-2">
<label>Tipo Identificación</label>
<select id="tipo_identificacion" class="form-control">
<option value="F">Física</option>
<option value="J">Jurídica</option>
</select>
</div>

<div class="mb-2">
<label>Identificación</label>
<input type="text" id="identificacion" class="form-control">
</div>

<div class="mb-2">
<label>Email</label>
<input type="email" id="email" class="form-control">
</div>

<div class="mb-2">
<label>Teléfono</label>
<input type="text" id="telefono" class="form-control">
</div>

<div class="mb-2">
<label>Dirección</label>
<textarea id="direccion" class="form-control"></textarea>
</div>

</form>

</div>

<div class="modal-footer">

<button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

<button class="btn btn-primary" onclick="guardarCliente()">
Guardar
</button>

</div>

</div>
</div>
</div>

<script>

async function guardarCliente(){

try{

const data={

nombre:document.getElementById("nombre").value,
tipo_identificacion:document.getElementById("tipo_identificacion").value,
identificacion:document.getElementById("identificacion").value,
email:document.getElementById("email").value,
telefono:document.getElementById("telefono").value,
direccion:document.getElementById("direccion").value

};

await axios.post(`${API_URL}/clientes`,data,{
headers:{ Authorization:`Bearer ${token}` }
});

// refrescar tabla
tabla.ajax.reload(null,false);

// limpiar formulario
document.getElementById("formCliente").reset();

// cerrar modal correctamente
const modalElement = document.getElementById('modalCliente');
const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
modal.hide();

// eliminar fondo oscuro si queda
document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
document.body.classList.remove('modal-open');

Swal.fire("Correcto","Cliente creado","success");

}catch(err){

console.error(err);
Swal.fire("Error","No se pudo guardar","error");

}

}

</script>