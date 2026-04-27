<div class="modal fade" id="modalProducto">

<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5>Nuevo Producto</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input id="codigo" class="form-control mb-2" placeholder="Código">
<input id="descripcion" class="form-control mb-2" placeholder="Descripción">
<input id="precio" type="number" class="form-control mb-2" placeholder="Precio">
<input id="stock_minimo" type="number" class="form-control mb-2" placeholder="Stock Minimo">

</div>

<div class="modal-footer">
<button class="btn btn-primary" onclick="guardar()">Guardar</button>
</div>

</div>
</div>
</div>

<script>

async function guardar(){

try{

const data = {
    codigo:document.getElementById("codigo").value,
    descripcion:document.getElementById("descripcion").value,
    precio_unitario:document.getElementById("precio").value,
    stock_minimo:document.getElementById("stock_minimo").value,
    tipo:"P",
    exento:false
};

await axios.post(`${API_URL}/productos`, data, {
headers:{ Authorization:`Bearer ${token}` }
});

// ✅ refrescar tabla
tabla.ajax.reload(null,false);

// ✅ limpiar formulario
document.getElementById("codigo").value="";
document.getElementById("descripcion").value="";
document.getElementById("precio").value="";
document.getElementById("stock_minimo").value="";

// ✅ cerrar modal correctamente
const modalElement = document.getElementById('modalProducto');
const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
modal.hide();

// ✅ eliminar fondo oscuro (bug bootstrap)
document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
document.body.classList.remove('modal-open');

// ✅ mostrar mensaje (DESPUÉS de cerrar)
Swal.fire({
    icon:"success",
    title:"Producto creado",
    timer:1500,
    showConfirmButton:false
});

}catch(err){

console.error(err);

Swal.fire({
    icon:"error",
    title:"Error",
    text:"No se pudo guardar"
});

}

}
</script>