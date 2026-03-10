<div class="modal fade" id="modalUsuario">
<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">
<h5>Nuevo Usuario</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input id="nombre" class="form-control mb-2" placeholder="Nombre">

<input id="email" class="form-control mb-2" placeholder="Email">

<input id="password" type="password" class="form-control mb-2" placeholder="Password">

<select id="rol" class="form-control">
<option value="admin">Admin</option>
<option value="user">User</option>
</select>

</div>

<div class="modal-footer">

<button class="btn btn-success" onclick="crearUsuario()">
Guardar
</button>

</div>

</div>
</div>
</div>
