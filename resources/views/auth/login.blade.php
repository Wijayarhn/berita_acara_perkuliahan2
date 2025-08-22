<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - BAP Online</title>

  <!-- Fonts and Styles -->
  <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
  <link href="{{ asset('admin_assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
  <link rel="icon" href="{{ asset('admin_assets/img/binabangsa.png') }}" type="image/x-icon">

  <style>
    body {
      background: linear-gradient(to right, #1e3c72, #2a5298);
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .form-control-user {
      border-radius: 1rem;
    }

    .btn-user {
      border-radius: 2rem;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .logo-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      animation: fadeIn 1.2s ease-in-out;
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: scale(0.8);
      }

      100% {
        opacity: 1;
        transform: scale(1);
      }
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-lg-6 col-md-8">
        <div class="card p-4">
          <div class="card-body">
            <div class="mb-4 text-center">
              <img src="{{ asset('admin_assets/img/binabangsa.png') }}" class="logo-img rounded-circle mb-3"
                alt="Logo Kampus">
              <h4 class="font-weight-bold text-gray-900">Login BAP Online</h4>
              <p class="text-muted small">Silakan masuk untuk melanjutkan</p>
            </div>

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="user">
              @csrf
              <div class="form-group">
                <input name="username" type="text" class="form-control form-control-user"
                  placeholder="Masukkan Username" value="{{ old('username') }}" required autofocus>
              </div>

              <div class="form-group">
                <input name="password" type="password" class="form-control form-control-user"
                  placeholder="Masukkan Password" required>
              </div>

              <div class="form-group">
                <div class="custom-control custom-checkbox small">
                  <input name="remember" type="checkbox" class="custom-control-input" id="rememberCheck">
                  <label class="custom-control-label" for="rememberCheck">Ingat saya</label>
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-user btn-block">
                <i class="fas fa-sign-in-alt mr-2"></i> Login
              </button>
            </form>

            <hr>
            {{-- Tambahan jika diperlukan --}}
            {{-- <div class="text-center">
              <a class="small" href="{{ route('password.request') }}">Lupa Password?</a>
            </div> --}}
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
