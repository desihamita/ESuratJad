<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-Surat | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="/" class="h1">E-<b>Surat</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="{{ route('login-proses') }}" method="post">
        @csrf
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" >
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror

        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
     </form>
      <p class="mb-0">
        <a href="/register" class="text-center">Register a new membership</a>
      </p>
    </div>
  </div>
</div>


<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

@if ($message = Session::get('failed'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Login Failed',
      text: '{{ $message }}'
    });
  </script>
@endif

</body>
</html>
