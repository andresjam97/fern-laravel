@extends('layouts.app')

@section('content')
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
<form action="{{ route('import-questions') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <center>
<div class="card">
    <div class="card-header" style="background:#00AB84; color:white;">
        <h4 align="center">Importador Preguntas quien quere se millonario</h4>
    </div>
    <div class="card-body">
        <a href="{{ asset('files/plantilla preguntas.xlsx') }}">Descargar Plantilla</a>
        <input type="file" name="adjunto" class="form-control">
        <br>
        <input type="submit" value="Guardar" class="btn btn-success" onclick="espera()">
    </div>

</div>
</center>

</form>
<script>
    function espera() {
        Swal.fire({
               title: 'Espera Por Favor !',
               html: '<p>Subiendo info</p>',
               allowOutsideClick: false,
               onBeforeOpen: () => {
                  Swal.showLoading()
               },
        });
    }
</script>
@endsection
