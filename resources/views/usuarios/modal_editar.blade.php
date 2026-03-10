<div class="modal fade" id="modalEditar">

<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">
<h5>Editar Usuario</h5>
</div>

<div class="modal-body">

<input type="hidden" id="edit_id">

<input id="edit_nombre" class="form-control mb-2">

<input id="edit_email" class="form-control mb-2">

<select id="edit_rol" class="form-control">
<option value="ADMIN">ADMIN</option>
<option value="USER">USER</option>
</select>

</div>

<div class="modal-footer">

<button class="btn btn-primary"
onclick="guardarEdicion()">

Guardar

</button>

</div>

</div>

</div>

</div>