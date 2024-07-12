
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fern - Colombia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/hot-sneaks/jquery-ui.css">

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

    @include('sweetalert::alert')

</head>
<body>
    <nav class="navbar bg-dark border-bottom border-body navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Fern - Colombia</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">Inicio</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="{{ route('game-qqsm') }}">Quien quiere ser millonario Juego</a>
              </li>

              @auth
                @if (auth()->user()->id == 2 || auth()->user()->id == 3)
                  <li class="nav-item">
                    <form action="{{route('truncate')}}" method="POST">
                      @csrf
                      <button type="submit" class="btn btn-info">Vaciar preguntas</button>
                    </form>
                  </li>
                @endif    
              @endauth
            </ul>
          </div>
        </div>
      </nav>
      <main>
        <div class="container">
          @if(session('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif
            @yield('content')
        </div>
    </main>
</body>
</html>


