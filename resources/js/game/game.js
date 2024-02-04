$(document).ready(function(){
    var currentQuestionId;
    var gameID;
    var score = 0;

    checkGame();

    $(".answer").click(function(){
        var selectedOption = $(this).attr('id');
        checkAnswer(currentQuestionId, selectedOption);
    });

    function checkGame() {
        $.ajax({
            type: "GET",
            url: "/game/last-game",
            success: function (response) {
                if (response.message == 'No existen juegos abiertos') {
                    Swal.fire({
                        title: "No Existen partidas Cargadas",
                        text: "Deseas iniciar una nueva partida?",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si"
                      }).then((result) => {
                        if (result.isConfirmed) {
                            newGame();
                        }
                      });
                } else {
                    $(".game-container").removeClass("d-none");
                    gameID = response.id;
                    renderQuestion(response.question);
                    renderScore(response.score);
                    renderLevel(response.level);
                    renderRank(response.rank_score);
                    renderPerformance(response.rank_accuracy);
                }
            }
        });
     }

     function newGame() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: "/game",
            success: function (response) {
                $(".game-container").removeClass("d-none");
                gameID = response.game_id;
                renderQuestion(response.question);
                renderScore(response.score);
                renderLevel(response.level);
                renderRank(response.rank_score);
                renderPerformance(response.rank_accuracy);
            }
        });
     }


    function checkAnswer(questionId, selectedOption) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: '/game/'+gameID+'/check-answer',
            type: 'PUT',
            data: {
                question_id: questionId,
                selected_option: selectedOption
            },
            success: function(response) {
                var selectedElement = $('#' + selectedOption);
                if (response.game_status == 'EN JUEGO') {
                    selectedElement.addClass('bg-success'); // Añade clase de Bootstrap para fondo verde

                    setTimeout(function() {
                        selectedElement.removeClass('bg-success');
                        renderQuestion(response.next_question);
                        renderScore(response.score);
                        renderLevel(response.level);
                    }, 2000);
                }
                else if(response.game_status == 'JUEGO GANADO'){
                    Swal.fire({
                        title: "Ganaste",
                        text: "Constestaste bien todas las preguntas",
                        imageUrl: "/images/Game/winner.gif",
                        imageWidth: 400,
                        imageHeight: 200,
                        imageAlt: "Custom image"
                      });
                      setTimeout(function() {
                        window.location.reload();
                    }, 3000); // Espera 2 segundos antes de reiniciar
                }
                else {
                    selectedElement.addClass('bg-danger'); // Añade clase de Bootstrap para fondo rojo
                    $('#' + response.correct_option).addClass('bg-success'); // Marca la respuesta correcta con verde
                    Swal.fire({
                        title: "Perdiste",
                        text: "Has Perdido :(",
                        imageUrl: "/images/Game/gameover.gif",
                        imageWidth: 400,
                        imageHeight: 200,
                        imageAlt: "Custom image"
                      });
                    setTimeout(function() {
                        selectedElement.removeClass('bg-danger');
                        $('#' + response.correct_option).removeClass('bg-success');
                        window.location.reload();
                    }, 3000); // Espera 2 segundos antes de reiniciar
                }
            }
        });
    }

    function renderQuestion(question) {
        $('#questionText').text(question.question);
        $('#a').text('A. '+question.option_a);
        $('#b').text('B. '+question.option_b);
        $('#c').text('C. '+question.option_c);
        $('#d').text('D. '+question.option_d);
    }

    function renderScore(score) {
        // Obtener el elemento span por su id
        var spanElement = document.getElementById('score');

        // Obtener el valor del span
        var oldScore = spanElement.innerHTML;

        var newScore = score;

        //  animarNumero(oldScore, newScore, spanElement, 0.1, "red");

        $('#score').text(score);
    }

    function renderLevel(level) {
        $('#level').text(level);
     }

    $('.rank').click(function (e) {
        e.preventDefault();
        $('#rankingTableScore').modal('show');
        loadTableRank();
    });

    $('.performance').click(function (e) {
        e.preventDefault();
        $('#rankingTablePerformance').modal('show');
        loadTableRankAcc();
    });
});
function animarNumero(inicio, fin, elemento, velocidad, colorFinal) {
    let numero = inicio;
    const intervalo = setInterval(function() {
      numero ++;
      elemento.textContent = numero;

      if (numero === fin) {
        elemento.style.color = colorFinal;
        clearInterval(intervalo);
      }
    }, velocidad);
  }


  function renderRank(rank){
    $('#rank').text(rank);
  }

  function renderPerformance(performance){
    $('#performance').text(performance);
  }


  function loadTableRank(){
    let url = "/game/ranking-score";
    let dt = $("#rankTableScore").DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: url,
        columns: [
            { data: "rnk_score" },
            { data: "name" },
        ],
        language: {
            emptyTable: "No hay datos disponibles en la tabla.",
            info: "Del _START_ al _END_ de _TOTAL_ ",
            infoEmpty: "Mostrando 0 registros de un total de 0.",
            infoFiltered: "(filtrados de un total de _MAX_ registros)",
            infoPostFix: "(actualizados)",
            lengthMenu: "Mostrar _MENU_ registros",
            loadingRecords: "Cargando...",
            processing:
                "<div class='spinner-border text-success' role='status'><span class='visually-hidden'>Loading...</span></div>",
            search: "Buscar:",
            searchPlaceholder: "Dato para buscar",
            zeroRecords: "No se han encontrado coincidencias.",
            paginate: {
                first: "Primera",
                last: "Última",
                next: "Siguiente",
                previous: "Anterior",
            },
            aria: {
                sortAscending: "Ordenación ascendente",
                sortDescending: "Ordenación descendente",
            },
        },

    });

  }


  function loadTableRankAcc(){
    let url = "/game/ranking-accuracy";
    let dt = $("#rankTablePerformance").DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: url,
        columns: [
            { data: "rnk_accuracy" },
            { data: "name" },
        ],
        language: {
            emptyTable: "No hay datos disponibles en la tabla.",
            info: "Del _START_ al _END_ de _TOTAL_ ",
            infoEmpty: "Mostrando 0 registros de un total de 0.",
            infoFiltered: "(filtrados de un total de _MAX_ registros)",
            infoPostFix: "(actualizados)",
            lengthMenu: "Mostrar _MENU_ registros",
            loadingRecords: "Cargando...",
            processing:
                "<div class='spinner-border text-success' role='status'><span class='visually-hidden'>Loading...</span></div>",
            search: "Buscar:",
            searchPlaceholder: "Dato para buscar",
            zeroRecords: "No se han encontrado coincidencias.",
            paginate: {
                first: "Primera",
                last: "Última",
                next: "Siguiente",
                previous: "Anterior",
            },
            aria: {
                sortAscending: "Ordenación ascendente",
                sortDescending: "Ordenación descendente",
            },
        },

    });

  }



