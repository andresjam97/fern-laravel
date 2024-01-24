$(document).ready(function () {

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

    $('#fecha').datepicker();

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

