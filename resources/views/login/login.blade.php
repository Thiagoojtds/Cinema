<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body style="background-color: #212529;">
<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Admin</h2>
              <p class="text-white-50 mb-5">Please enter your login and password!</p>
              @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div class="error">{{ $error }}</div>
                @endforeach
              @endif
              <form action="{{ route('auth') }}" method="post">
                @csrf
                <input type="email" placeholder="Email" name="email"><br><br>
                <input type="password" placeholder="Senha" name="password"><br><br>
                <button class="btn btn-danger"type="submit">Enviar</button>
              </form>

            

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>