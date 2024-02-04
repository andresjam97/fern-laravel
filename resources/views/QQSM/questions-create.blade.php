@extends('layouts.app')

@section('content')

<br><br>
<div class="card">
    <div class="card-header">
      Creacion Preguntas Quien quiere ser millonario
    </div>
    <div class="card-body">
            @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>

    @endif

    @if (\Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('message') !!}</li>
            </ul>
        </div>
    @endif
        <form action="{{ route('create-question') }}" method="post" autocomplete="off">
            @csrf
            <div class="row row-cols-2">
                <div class="col">
                    <div class="form-group">
                        <label for="question" class="form-label">Pregunta</label>
                        <input type="text" class="form-control" name="question" id="question" required>
                    </div>

                </div>

                <div class="col">
                    <div class="form-group">
                        <label for="option_a" class="form-label">Opcion A</label>
                        <input type="text" class="form-control" name="option_a" id="option_a" required>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label for="option_b" class="form-label">Opcion B</label>
                        <input type="text" class="form-control" name="option_b" id="option_b" required>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label for="option_c" class="form-label">Opcion C</label>
                        <input type="text" class="form-control" name="option_c" id="option_c" required>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label for="option_d" class="form-label">Opcion D</label>
                        <input type="text" class="form-control" name="option_d" id="option_d" required>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label for="correct_option" class="form-label">Opcion Correcta</label>
                        <select name="correct_option" id="correct_option" class="form-select" required>
                            <option value="">Selecciona una opcion</option>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                        </select>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label for="level" class="form-label">Nivel</label>
                        <select name="level" id="level" class="form-select" required>
                            <option value="">Selecciona una opcion</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
            </div>
            <br><br>
            <button type="submit" class="btn btn-success">Enviar</button>
        </form>
    </div>
  </div>



@endsection
