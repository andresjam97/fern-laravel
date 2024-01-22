$(document).ready(function () {
    var availableTags = [
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"
      ];

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
        source: availableTags
      });

});

