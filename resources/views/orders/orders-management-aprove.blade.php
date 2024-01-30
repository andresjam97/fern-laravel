@extends('layouts.app')
@section('content')
<center>
    <h1>Gestion de aprobacion</h1>
</center>
<br>
<button class="btn btn-success btn-md" data-bs-toggle="modal" data-bs-target="#addPedido">
    <i class="fa-solid fa-plus"></i>
</button>
<br><br>
<div class="table-responsive">
    <table class="table" id="table-orders-main">
        <thead class="table-success">
            <tr>
                <th scope="col">ID Solicitud</th>
                <th scope="col">Estado</th>
                <th scope="col">Tipo Solicitud</th>
                <th scope="col">Fecha Requerida entrega</th>
                <th scope="col">Colegio</th>
                <th scope="col">Ver Detalles</th>
                <th scope="col">Editar Pedido</th>
                <th scope="col">Confirmacion despacho</th>
                <th scope="col">Gestion de pedido</th>
                <th scope="col">Pedidos Aprobados</th>
                <th scope="col">Albaran</th>
                <th scope="col">Documento Final</th>
            </tr>
        </thead>
    </table>
</div>
@endsection
