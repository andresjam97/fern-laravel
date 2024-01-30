@extends('layouts.app')
@section('content')
    @vite(['resources/css/orders/orders.css', 'resources/js/orders/orders.js'])

    <!-- Modal agregar-->
    <div class="modal fade modal-lg" id="addPedido" tabindex="-1" aria-labelledby="addPedido" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Solicitud Pedido</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('orders-create') }}">
                        @csrf
                        <div class="row row-cols-2 ui-front">
                            <div class="col">
                                <label for="tipo_solicitud">Tipo Solicitud</label>
                                <select name="tipo_solicitud" id="tipo_solicitud" class="form-select">
                                    <option value="">Seleccione una Opcion</option>
                                    <option value="Solicitud para muestra"> Solicitud para muestra</option>
                                    <option value="Solicitud para venta">Solicitud para venta</option>
                                    <option value="Movimiento de inventario a bodega">Movimiento de inventario a bodega
                                    </option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="vendedor">Vendedor</label>
                                <select name="vendedor" id="vendedor" class="form-select">
                                    <option value="">Seleccione una Opcion</option>
                                    @foreach ($empleados as $empleado)
                                        <option value="{{ $empleado->id }}">{{ $empleado->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="fecha">Fecha Requerida de entrega</label>
                                <input type="text" class="form-control" id="fecha" name="fecha">
                            </div>

                            <div class="col">
                                <label for="colegio">Colegio</label>
                                <input type="text" class="form-control" id="colegio" name="colegio">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Enviar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal ver -->
    <div class="modal fade modal-lg" id="verPedido" tabindex="-1" aria-labelledby="verPedido" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ver Pedido</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-stripped" id="table-details">
                            <thead class="table-success">
                                <th>Libro</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Enviar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade modal-lg" id="gestionPedido" tabindex="-1" aria-labelledby="gestionPedido" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Gestion de Pedido</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-stripped" id="table-books">
                            <thead class="table-success">
                                <th>Libro</th>
                                <th>Cantidad</th>
                                <th>Gestion</th>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Enviar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>





    <br>
    <center>
        <h1>Mis Pedidos</h1>
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
