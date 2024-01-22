@extends('layouts.app')
@section('content')
    @vite(['resources/css/orders/orders-details.css', 'resources/js/orders/orders-details.js'])
    <br>
    <br>

    <div class="card">
        <div class="card-header">
            Datos Pedido
        </div>
        <div class="card-body">
            <div class="row row-cols-2">
                <div class="col">
                    <p class="card-text"><strong>Tipo solicitud: </strong>{{ $order->tipo }}</p>
                </div>
                <div class="col">
                    <p class="card-text"><strong>Vendedor: </strong>{{ $order->user_id }}</p>
                </div>

                <div class="col">
                    <br>
                    <p class="card-text"><strong>Fecha requerida: </strong>{{ $order->fecha_requerida }}</p>
                </div>
                <div class="col">
                    <br>
                    <p class="card-text"><strong>Colegio: </strong>{{ $order->id_colegio }}</p>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="card">
        <div class="card-header">
            Ingreso Detalles
        </div>
        <div class="card-body">
            <form id="details">
                <input type="hidden" name="identify" id="identify" value="{{ $order->id }}">

                <div class="row row-cols-2">
                    <div class="col">
                        <label for="libro" class="form-label">Libro</label>
                        <input type="text" class="form-control" name="book" id="libro">
                    </div>

                    <div class="col">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="quantity" id="cantidad">
                    </div>

                    <div class="col">
                        <label for="discount" class="form-label">Descuento</label>
                        <input type="text" class="form-control" name="discount" id="discount">
                    </div>

                    <div class="col">
                        <label for="otros" class="form-label">Otros Libros</label>
                        <select class="form-select" id="otros" name="otros">
                            <option value="">Seleccione una opcion</option>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div id="libros" class="d-none">
                        <div class="col">
                            <label for="bookName" class="form-label">Nombre de el libro</label>
                            <input type="text" class="form-control" name="bookName" id="bookName">
                        </div>
                        <div class="col">
                            <label for="bookPrice" class="form-label">Precio de el libro</label>
                            <input type="text" class="form-control" name="bookPrice" id="bookPrice">
                        </div>
                    </div>
                </div>
        </div>
        <button type="submit" class="btn btn-success">Enviar</button>
        </form>
    </div>


    <hr>

    <br><br>

    <div class="table-responsive">
        <table class="table table-stripped" id="table-details">
            <thead class="table-success">
                <th>Libro</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Eliminar</th>
            </thead>

        </table>
    </div>
    </div>


    @if (session('alerta'))
        <script>
            window.onload = function() {
                Swal.fire({
                    type: '{{ session('alerta.tipo') }}',
                    title: '{{ session('alerta.titulo') }}',
                    text: '{{ session('alerta.texto') }}',
                });
            }
        </script>
    @endif
@endsection
