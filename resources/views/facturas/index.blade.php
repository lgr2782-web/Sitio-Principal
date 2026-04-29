@extends('layouts.app')

@section('title','Facturación')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h4>Facturación</h4>
        </div>

        <div class="card-body">

            <!-- ENCABEZADO -->
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Cliente</label>
                    <select id="cliente" name="id_cliente" style="width:100%"></select>
                </div>

                <div class="col-md-2 mb-3">
                    <label>Fecha</label>
                    <input
                        type="date"
                        id="fecha"
                        class="form-control"
                        value="{{ date('Y-m-d') }}">
                </div>

                <div class="col-md-2 mb-3">
                    <label>Tipo Documento</label>
                    <select id="tipo_documento" class="form-control">
                        <option value="01">Factura</option>
                        <option value="04">Tiquete</option>
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label>Consecutivo</label>
                    <input
                        type="text"
                        id="numero_consecutivo"
                        class="form-control"
                        readonly
                        value="{{ $numeroConsecutivo }}">
                </div>

            </div>

            <hr>

            <!-- PRODUCTOS -->
            <div class="row align-items-end">

                <div class="col-md-6 mb-3">
                    <label>Producto</label>
                    <select id="producto" style="width:100%"></select>
                </div>

                <div class="col-md-2 mb-3">
                    <label>Cantidad</label>
                    <input
                        type="number"
                        id="cantidad"
                        min="1"
                        class="form-control">
                </div>

                <div class="col-md-2 mb-3">
                    <label>Descuento %</label>
                    <input
                        type="number"
                        id="descuento"
                        class="form-control"
                        value="0">
                </div>

                <div class="col-md-2 mb-3">
                    <button
                        type="button"
                        class="btn btn-primary w-100"
                        onclick="agregarLinea()">
                        Agregar
                    </button>
                </div>

            </div>

            <hr>

            <!-- DETALLE -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Desc.</th>
                            <th>Impuesto</th>
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="detalle-body"></tbody>
                </table>
            </div>

            <!-- TOTALES -->
            <div class="row mt-4">

                <div class="col-md-3 offset-md-9">

                    <div class="mb-2">
                        <label>Subtotal</label>
                        <input
                            type="text"
                            id="subtotal"
                            readonly
                            class="form-control"
                            value="0">
                    </div>

                    <div class="mb-2">
                        <label>Impuesto</label>
                        <input
                            type="text"
                            id="impuesto"
                            readonly
                            class="form-control"
                            value="0">
                    </div>

                    <div class="mb-2">
                        <label>Total</label>
                        <input
                            type="text"
                            id="total"
                            readonly
                            class="form-control"
                            value="0">
                    </div>

                    <button
                        class="btn btn-success w-100"
                        onclick="guardarFactura()">
                        Guardar Factura
                    </button>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection

@section('scripts')

<script>

let detalle = [];

$(document).ready(function () {

    // CLIENTES
    $('#cliente').select2({
        width: '100%',
        placeholder: 'Buscar cliente...',
        allowClear: true,
        minimumInputLength: 1,
        ajax: {
            url: '/facturas/clientes',
            dataType: 'json',
            delay: 250,
            data: function(params){
                return {
                    q: params.term || ''
                };
            },
            processResults: function(data){
                return {
                    results: data.map(item => ({
                        id: item.id_cliente,
                        text: item.nombre
                    }))
                };
            }
        }
    });

    // PRODUCTOS
    $('#producto').select2({
        width: '100%',
        placeholder: 'Buscar producto...',
        allowClear: true,
        minimumInputLength: 1,
        ajax: {
            url: '/facturas/productos',
            dataType: 'json',
            delay: 250,
            data: function(params){
                return {
                    q: params.term || ''
                };
            },
            processResults: function(data){
                return {
                    results: data.map(item => ({
                        id: item.id_producto,
                        text: item.codigo + ' - ' + item.descripcion,
                        precio: Number(item.precio_unitario),
                        stock: Number(item.stock)
                    }))
                };
            }
        }
    });

});

function agregarLinea() {

    let producto = $('#producto').select2('data')[0];
    let cantidad = Number($('#cantidad').val()) || 0;
    let descuentoPorcentaje = Number($('#descuento').val()) || 0;

    if (!producto) {
        Swal.fire({
            icon: 'warning',
            title: 'Seleccione un producto'
        });
        return;
    }

    if (cantidad <= 0) {
        Swal.fire({
            icon: 'warning',
            title: 'La cantidad debe ser mayor a cero'
        });
        return;
    }

    if (cantidad > producto.stock) {
        Swal.fire({
            icon: 'error',
            title: 'Stock insuficiente',
            html: `
                Producto: <b>${producto.text}</b><br>
                Disponible: <b>${producto.stock}</b><br>
                Solicitado: <b>${cantidad}</b>
            `
        });
        return;
    }

    let precio = Number(producto.precio);
    let subtotal = precio * cantidad;
    let descuento = subtotal * (descuentoPorcentaje / 100);
    let base = subtotal - descuento;
    let impuesto = base * 0.13;
    let total = base + impuesto;

    detalle.push({
        id_producto: producto.id,
        nombre: producto.text,
        cantidad: cantidad,
        precio: precio,
        descuento: descuento,
        impuesto: impuesto,
        subtotal: base,
        total: total
    });

    renderDetalle();

    $('#producto').val(null).trigger('change');
    $('#cantidad').val('');
    $('#descuento').val(0);
}

function renderDetalle() {

    let filas = '';
    let subtotalGeneral = 0;
    let impuestoGeneral = 0;
    let totalGeneral = 0;

    detalle.forEach((item, index) => {

        filas += `
            <tr>
                <td>${item.nombre}</td>
                <td>${item.cantidad}</td>
                <td>${item.precio.toFixed(2)}</td>
                <td>${item.descuento.toFixed(2)}</td>
                <td>${item.impuesto.toFixed(2)}</td>
                <td>${item.subtotal.toFixed(2)}</td>
                <td>${item.total.toFixed(2)}</td>
                <td>
                    <button
                        onclick="eliminarLinea(${index})"
                        class="btn btn-danger btn-sm">
                        X
                    </button>
                </td>
            </tr>
        `;

        subtotalGeneral += item.subtotal;
        impuestoGeneral += item.impuesto;
        totalGeneral += item.total;
    });

    document.getElementById('detalle-body').innerHTML = filas;
    document.getElementById('subtotal').value = subtotalGeneral.toFixed(2);
    document.getElementById('impuesto').value = impuestoGeneral.toFixed(2);
    document.getElementById('total').value = totalGeneral.toFixed(2);
}

function eliminarLinea(index){
    detalle.splice(index, 1);
    renderDetalle();
}

function guardarFactura() {

    let cliente = $('#cliente').val();
    let fecha = $('#fecha').val();
    let tipo_documento = $('#tipo_documento').val();
    let numero_consecutivo = $('#numero_consecutivo').val();

    if (!cliente) {
        Swal.fire({
            icon: 'warning',
            title: 'Debe seleccionar un cliente'
        });
        return;
    }

    if (detalle.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Debe agregar al menos un producto'
        });
        return;
    }

    let data = {
        id_cliente: cliente,
        fecha_emision: fecha,
        tipo_documento: tipo_documento,
        numero_consecutivo: numero_consecutivo,
        subtotal: Number($('#subtotal').val()),
        impuesto: Number($('#impuesto').val()),
        total: Number($('#total').val()),
        detalle: detalle
    };

    $.ajax({
        url: '/facturas',
        method: 'POST',
        contentType: 'application/json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify(data),
        success: function(response){

            Swal.fire({
                icon: 'success',
                title: 'Factura creada correctamente'
            }).then(() => {
                location.reload();
            });

        },
        error: function(error){

            Swal.fire({
                icon: 'error',
                title: 'Error creando factura',
                text: error.responseJSON?.message || 'Ocurrió un error'
            });

        }
    });

}

</script>

@endsection