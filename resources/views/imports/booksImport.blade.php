@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
      Importar Libros
    </div>
    <div class="card-body">

      <h5 class="card-title">Importador Libros</h5>
       @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('import-book') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="formFile" class="form-label">Adjunto <a href="{{ asset('files/plantilla libros.xltx') }}">Descargar Plantilla</a></label>
                <input class="form-control" type="file" id="formFile" name="adjunto">

            </div>
            <br><br>
            <button type="submit" class="btn btn-success">Subir</button>
        </form>
    </div>
  </div>
@endsection
