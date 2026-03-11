<aside id="sidebar" class="sidebar">
<div class="sidebar-header">
<i class="bi bi-speedometer2"></i>
<span class="logo-text">Admin</span>
</div>


<ul class="menu">
<li><a href="{{ route('dashboard') }}"><i class="bi bi-house"></i><span>Inicio</span></a></li>
<li class="nav-item">
    <a href="{{ route('usuarios') }}" class="nav-link">
        <i class="bi bi-people"></i>
        <span>Usuarios</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('empresa') }}">
    <i class="bi bi-building"></i> Empresa
    </a>
</li>
<li>
<a href="/clientes">
<i class="bi bi-people"></i> Clientes
</a>
</li>
<li><a href="#"><i class="bi bi-gear"></i><span>Configuración</span></a></li>
</ul>
</aside>