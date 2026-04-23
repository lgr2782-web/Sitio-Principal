<div class="modal fade" id="modalInventario">

<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5>Movimiento de Inventario</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-2">
<label>Producto</label>
<select id="producto" class="form-control"></select>
</div>

<div class="mb-2">
<label>Cantidad</label>
<input type="number" id="cantidad" class="form-control">
</div>

<div class="mb-2">
<label>Tipo</label>
<select id="tipo" class="form-control">
<option value="ENTRADA">Entrada</option>
<option value="SALIDA">Salida</option>
</select>
</div>

</div>

<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
<button class="btn btn-primary" onclick="guardarMovimiento()">Guardar</button>
</div>

</div>
</div>
</div>

<script>
    async function cargarProductos(){

try{

const res = await axios.get(`${API_URL}/productos`,{
headers:{ Authorization:`Bearer ${token}` }
});

let options = '<option value="">Seleccione</option>';

res.data.forEach(p=>{
options += `<option value="${p.id_producto}">${p.descripcion}</option>`;
});

document.getElementById("producto").innerHTML = options;

}catch(err){
console.error(err);
}

}


async function guardarMovimiento(){

try{

const data = {
id_producto:document.getElementById("producto").value,
cantidad:document.getElementById("cantidad").value
};

const tipo = document.getElementById("tipo").value;

await axios.post(`${API_URL}/inventario/${tipo.toLowerCase()}`,data,{
headers:{ Authorization:`Bearer ${token}` }
});

// refrescar tabla
tabla.ajax.reload(null,false);

// cerrar modal
const modal = bootstrap.Modal.getInstance(document.getElementById('modalInventario'));
modal.hide();

// limpiar fondo
document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
document.body.classList.remove('modal-open');

// limpiar campos
document.getElementById("producto").value="";
document.getElementById("cantidad").value="";

// mensaje
Swal.fire({
icon:"success",
title:"Movimiento registrado",
timer:1500,
showConfirmButton:false
});

}catch(err){

console.error(err);

Swal.fire("Error","No se pudo guardar","error");

}

}
</script>