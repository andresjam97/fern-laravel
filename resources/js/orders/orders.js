$(document).ready(function () {
    inicializar();
    $('#fecha').datepicker();

    $("#table-orders-main").on("click", ".ver", function () {
        var id = $(this).data("id");
        ver(id);
    });

    $("#table-orders-main").on("click", ".confirm", function () {
        var id = $(this).data("id");
        Swal.fire({
            title: "Estas seguro?",
            text: "Deseas confirmar el despacho de este pedido?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si"
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    url: "/orders/confirm/"+id,
                    success: function (response) {
                        Swal.fire(
                            'Exito',
                            'Orden confirmada con exito',
                            'success'
                        )
                        inicializar();
                    },
                    error: function(error){
                        Swal.fire(
                            'Error',
                            'Error interno',
                            'error'
                        )
                        console.error(error);
                    }
                });
            }
          });
    });

    $("#table-orders-main").on("click", ".manage", function () {
        var id = $(this).data("id");
        $("#gestionPedido").modal("show");
        tablaLibros(id);
    });

    $("#table-books").on("click", ".return", function () {
        var id = $(this).data("id");
        console.log("devolucion");
    });

    $("#table-books").on("click", ".sell", function () {
        var id = $(this).data("id");
        console.log("venta");
    });

    $("#table-books").on("click", ".pending", function () {
        var id = $(this).data("id");
        console.log("pendiente");
    });






function inicializar() {
    $('#table-orders-main').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "/orders/getOrders",
        "columns": [
            { "data": "id" },
            { "data": "estado" },
            { "data": "tipo" },
            { "data": "fecha_requerida" },
            { "data": "id_colegio" },
            { "data": "detalles" },
            { "data": "editar" },
            { "data": "confirm" },
            { "data": "manage" },
            { "data": "confirmed-orders" },
            { "data": "albaran" },
            { "data": "document" },

        ]
    });
}

function tablaLibros(id) {
    $('#table-books').DataTable({
        "processing": true,
        "serverSide": true,
        "destroy" : true,
        "ajax": "/orders/getOrderDetails/"+id,
        "columns": [
            { "data": "id_book" },
            { "data": "quantity" },
            { "data": "manage" },

        ]
    });
}

    function ver(id) {
        $("#verPedido").modal("show");
        $('#table-details').DataTable({
            "processing": true,
            "serverSide": true,
            "destroy" : true,
            "ajax": "/orders/getOrderDetails/"+id,
            "columns": [
                { "data": "id_book" },
                { "data": "quantity" },
                { "data": "id_book" },

            ]
        });
     }

    $( "#colegio" ).autocomplete({
        source: function(request, response) {
            // Realizar la solicitud AJAX para obtener sugerencias
            let empleado = $('#vendedor').val();
            $.ajax({
                url: "/orders/getSchools/"+empleado,
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {

                      var sugerenciasMapeadas = data.map(function(item) {
                        return {
                            label: item.name,
                            value: item.id
                        };
                    });
                    response(sugerenciasMapeadas);
                },
                error: function(error) {
                    console.error('Error al obtener sugerencias: ', error);
                }
            });
        },
        minLength: 3,
        select: function(event, ui) {
            // Aquí puedes acceder al ID seleccionado a través de ui.item.value
            console.log('ID seleccionado:', ui.item.value);
        }
    });
});

