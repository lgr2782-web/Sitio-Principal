<div class="modal fade" id="modalEditar">

<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5>Editar Producto</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="hidden" id="edit_id">

<input id="edit_codigo" class="form-control mb-2" placeholder="Código">
<input id="edit_descripcion" class="form-control mb-2" placeholder="Descripción">
<input id="edit_precio" type="number" class="form-control mb-2" placeholder="Precio">

</div>

<div class="modal-footer">
<button class="btn btn-primary" onclick="actualizar()">Actualizar</button>
</div>

</div>
</div>
</div>

<script>
    async function actualizar(){

try{

const id = document.getElementById("edit_id").value;

await axios.put(`${API_URL}/productos/${id}`,{

codigo:document.getElementById("edit_codigo").value,
descripcion:document.getElementById("edit_descripcion").value,
precio_unitario:document.getElementById("edit_precio").value,
tipo:"P",
exento:false

},{
headers:{ Authorization:`Bearer ${token}` }
});

// refrescar tabla
tabla.ajax.reload(null,false);

// cerrar modal
const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditar'));
modal.hide();

// limpiar fondo oscuro
document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
document.body.classList.remove('modal-open');

// mensaje
Swal.fire("Actualizado","Producto actualizado","success");

}catch(err){

console.error(err);
Swal.fire("Error","No se pudo actualizar","error");

}

}
</script>