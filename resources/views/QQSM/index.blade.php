@extends('layouts.app')
@section('content')
@vite(['resources/js/game/game.js','resources/css/game/game.css'])

{{-- <x-ui.modal id="rankingTableScore" title="Ranking Usuarios por puntaje">

    <x-ui.table :headers="[
        'Ranking',
        'Usuario',
    ]" id="rankTableScore">
    </x-ui.table>
</x-ui.modal>


<x-ui.modal id="rankingTablePerformance" title="Ranking Usuarios Performance">

    <x-ui.table :headers="[
        'Ranking',
        'Usuario',
    ]" id="rankTablePerformance">
    </x-ui.table>
</x-ui.modal> --}}

<div class="game-container d-none">
    <div class="image-container">
        <!-- Imagen en el extremo izquierdo -->
        {{-- <img src="{{ asset('images/Game/encabezado.png') }}" alt="Left Image" class="left-image"> --}}
    </div>

    <div class="image-container">
        <!-- Imagen en el extremo derecho -->
        {{-- <img src="{{ asset('images/Game/encabezado-evolucion.png') }}" alt="Right Image" class="right-image"> --}}
    </div>

    <div class="logo-container">
        <!-- Logo del juego -->
        <img src="{{ asset('images/game/fern-fondo.png') }}" width="100%" height="30%" alt="Logo">
    </div>


    <div class="question-container">
        <p id="questionText">Aquí va la pregunta...</p>
    </div>

    <div class="answers-container">
        <div class="answer" id="a">A: <span>Opción A</span></div>
        <div class="answer" id="b">B: <span>Opción B</span></div>
        <div class="answer" id="c">C: <span>Opción C</span></div>
        <div class="answer" id="d">D: <span>Opción D</span></div>
    </div>

    <br>


    <div class="icon-stripe">
        <div class="icon-container score">
            <img src="{{asset('images/game/puntaje.png')}}" width="100px" height="100px" alt="Puntaje">
            <span class="icon-number" id="score">0</span>
            <p class="image-text">Puntuacion</p>
        </div>
        <div class="icon-container nivel">
            <img src="{{asset('images/game/nivel.png')}}" width="100px" height="100px" alt="Nivel">
            <span class="icon-number" id="level">0</span>
            <p class="image-text">Nivel</p>
        </div>
        <div class="icon-container ranking">
            <img src="{{asset('images/game/ranking.png')}}" width="100px" class="rank" height="100px" alt="Ranking" class="rank">
            <span class="icon-number" id="rank">0</span>
            <p class="image-text">Ranking</p>
        </div>
        <div class="icon-container performance">
            <img src="{{asset('images/game/performance.png')}}" width="100px" height="100px" alt="Performance" class="performance">
            <span class="icon-number" id="performance">0</span>
            <p class="image-text">Performance</p>
        </div>
    </div>
</div>
@endsection
