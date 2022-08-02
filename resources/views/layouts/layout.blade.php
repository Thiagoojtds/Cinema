<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Cinema</title>
    <link rel="icon" href="../../img/favicon.ico">
</head>
<body style="background-color: #3d403f;">
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('home') }}">Cinema</a>
      <form class="d-flex" method="POST" action="{{ route('search') }}" style="margin-right: 500px;">
        @csrf
        <input class="form-control me-2" type="search" name="search" placeholder="tags, nomes">
        <button class="btn btn-outline-secondary"type="submit">Buscar</button>
      </form>
      <div>
        @auth
          <form action="{{ route('logout') }}" style="float: right; margin-right: 10px;">
              <button class="btn btn-outline-danger"type="submit">Sair</button>
          </form>
        @endauth
        <form class="d-flex" action="{{ route('adminPage') }}" style="float:right; margin-right: 10px;">
          <button class="btn btn-outline-danger" type="submit">Admin</button>
        </form>
        <form class="d-flex" action="{{ route('nextDays') }}" style="float: right; margin-right: 10px;">
          <button class="btn btn-outline-danger" type="submit">Próximos 5 dias</button>
        </form>
        <form class="d-flex" action="{{ route('lastDays') }}" style="float: right; margin-right: 10px;">
          <button class="btn btn-outline-danger" type="submit">Últimos 10 dias</button>
        </form>
    </div>
    </div>
  </nav>

@if ($errors->any())
     @foreach ($errors->all() as $error)
     <div class="alert alert-danger" role="alert">{{ $error }}</div>
     @endforeach
@endif


@yield('content')



</body>
</html>