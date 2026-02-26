@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row g-3">

        <!-- Productos -->
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5>Productos</h5>
                    <h2>{{ $resumen['productos'] }}</h2>
                </div>
            </div>
        </div>

        <!-- Clientes -->
        <div class="col-md-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5>Clientes</h5>
                    <h2>{{ $resumen['clientes'] }}</h2>
                </div>
            </div>
        </div>

        <!-- Ventas hoy -->
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5>Ventas Hoy</h5>
                    <h2>₡{{ number_format($resumen['ventas_hoy'], 0) }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Facturas -->
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <h5>Total Facturas</h5>
                    <h2>{{ $resumen['total_facturas'] }}</h2>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
