@extends('layouts.app')
@section('content')
<br><br>
<div class="card">
    <div class="card-header">
      Importar Empleados
    </div>
    <div class="card-body">
      <h5 class="card-title">Importador Empleados</h5>
        <form action="{{ route('import-employe') }}" action="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="formFile" class="form-label">Adjunto</label>
                <input class="form-control" type="file" id="formFile" name="adjunto">

            </div>
            <button type="submit" class="btn btn-success">Subir</button>
        </form>
    </div>
  </div>
@endsection
