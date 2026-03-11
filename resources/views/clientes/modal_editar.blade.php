<div class="modal fade" id="modalEditar">

<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5>Editar Cliente</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="hidden" id="edit_id">

<div class="mb-2">
<label>Nombre</label>
<input type="text" id="edit_nombre" class="form-control">
</div>

<div class="mb-2">
<label>Identificación</label>
<input type="text" id="edit_identificacion" class="form-control">
</div>

<div class="mb-2">
<label>Email</label>
<input type="email" id="edit_email" class="form-control">
</div>

<div class="mb-2">
<label>Teléfono</label>
<input type="text" id="edit_telefono" class="form-control">
</div>

</div>

<div class="modal-footer">

<button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

<button class="btn btn-primary" onclick="actualizarCliente()">
Actualizar
</button>

</div>

</div>
</div>
</div>

<script>

function editarCliente(cliente){

document.getElementById("edit_id").value=cliente.id_cliente;
document.getElementById("edit_nombre").value=cliente.nombre;
document.getElementById("edit_identificacion").value=cliente.identificacion;
document.getElementById("edit_email").value=cliente.email;
document.getElementById("edit_telefono").value=cliente.telefono;

new bootstrap.Modal(document.getElementById('modalEditar')).show();

}

async function actualizarCliente(){

const id=document.getElementById("edit_id").value;

const data={

nombre:document.getElementById("edit_nombre").value,
tipo_identificacion:"F",
identificacion:document.getElementById("edit_identificacion").value,
email:document.getElementById("edit_email").value,
telefono:document.getElementById("edit_telefono").value,
direccion:""

};

await axios.put(`${API_URL}/clientes/${id}`,data,{
headers:{ Authorization:`Bearer ${token}` }
});

Swal.fire("Actualizado","Cliente actualizado","success");

tabla.ajax.reload();

bootstrap.Modal.getInstance(document.getElementById('modalEditar')).hide();

}

async function eliminarCliente(id){

const confirm=await Swal.fire({

title:"Eliminar",
text:"¿Deseas eliminar el cliente?",
icon:"warning",
showCancelButton:true

});

if(!confirm.isConfirmed) return;

await axios.delete(`${API_URL}/clientes/${id}`,{
headers:{ Authorization:`Bearer ${token}` }
});

tabla.ajax.reload();

}

</script>