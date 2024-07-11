@extends('layouts.app')
@section('content')
<br><br>
<div class="card">
    <div class="card-header">
      Importar Preguntas QQSM
    </div>
    <div class="card-body">

      <h5 class="card-title">Importador Peguntas QQSM</h5>
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
        <form action="{{ route('import-questions') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input class="form-control" type="file" id="formFile" name="adjunto">

            </div>
            <br><br>
            <button type="submit" class="btn btn-success">Subir</button>
        </form>
    </div>
  </div>
@endsection
