<nav class="navbar px-3">
<button class="btn btn-outline-secondary" onclick="toggleSidebar()">
<i class="bi bi-list"></i>
</button>


<div class="ms-auto">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="btn btn-danger btn-sm">Salir</button>
</form>
</div>
</nav>