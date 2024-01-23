$(document).ready(function () {
    let id = $('#identify').val();

    inicializarTabla(id);

    $('#details').submit(function (e) {
        e.preventDefault();
        let id = $('#identify').val();
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
        $.ajax({
            url: '/orders/'+id,
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire(
                    'Exito',
                    'Informacion ingresada con exito',
                    'success'
                )
                $("#details")[0].reset();
                inicializarTabla(id);
            },
            error: function(xhr, status, error) {
                console.log(error);
                Swal.fire(
                    'Error',
                    'Error interno',
                    'error'
                )
            }
        });
    });



});

function inicializarTabla(id) {
    $('#table-details').DataTable({
        "processing": true,
        "serverSide": true,
        "destroy" : true,
        "ajax": "/orders/getOrderDetails/"+id,
        "columns": [
            { "data": "id_book" },
            { "data": "quantity" },
            { "data": "id_book" },
            { "data": "destroy" },

        ]
    });
 }


document.getElementById('otros').addEventListener('change', function() {
    var valor = this.value;
    var div = document.getElementById('libros');

    if(valor === 'Si') {
        div.classList.remove('d-none');
    } else {
        div.classList.add('d-none');
    }
  });

  $('.finalizar').click(function (e) {
    e.preventDefault();
    let id = $('#identify').val();
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $.ajax({
        type: "POST",
        url: "/orders/send",
        data: {
            "id" : id
        },
        success: function (response) {
            Swal.fire(
                'Exito',
                'Orden enviada con exito',
                'success'
            )
            window.location.href('/orders');
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
  });


