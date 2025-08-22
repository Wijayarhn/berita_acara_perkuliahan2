<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="BAP Online Register Page">
  <title>Register - BAP Online</title>

  <!-- Fonts -->
  <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('admin_assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
  <link rel="icon" href="{{ asset('admin_assets/img/binabangsa.png') }}" type="image/x-icon">
</head>

<body class="bg-gradient-primary">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-8 col-md-10">
        <div class="card o-hidden my-5 border-0 shadow-lg">
          <div class="card-body p-0">
            <div class="p-5">
              <div class="text-center">
                <img src="{{ asset('admin_assets/img/binabangsa.png') }}" alt="Logo"
                  class="img-fluid rounded-circle mb-4" style="width: 100px; height: 100px;">
                <h1 class="h4 mb-4 text-gray-900">Create an Account</h1>
              </div>

              {{-- Error message --}}
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              {{-- Registration Form --}}
              <form action="{{ route('register.save') }}" method="POST" class="user">
                @csrf

                {{-- Pilih Role --}}
                <div class="form-group">
                  <select name="role" class="form-control form-control-user" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                  </select>
                </div>

                {{-- Nama --}}
                <div class="form-group">
                  <input name="nama" type="text" class="form-control form-control-user" placeholder="Nama Lengkap"
                    value="{{ old('nama') }}" required>
                </div>

                {{-- Username --}}
                <div class="form-group">
                  <input name="username" type="text" class="form-control form-control-user" placeholder="Username"
                    value="{{ old('username') }}" required>
                </div>

                {{-- NIM/NIDN (opsional) --}}
                <div class="form-group">
                  <input name="nidn" type="text" class="form-control form-control-user"
                    placeholder="NIDN (khusus dosen)" value="{{ old('nidn') }}">
                </div>

                <div class="form-group">
                  <input name="nim" type="text" class="form-control form-control-user"
                    placeholder="NIM (khusus mahasiswa)" value="{{ old('nim') }}">
                </div>

                <div class="form-group">
                  <input name="kelas" type="text" class="form-control form-control-user"
                    placeholder="Kelas (khusus mahasiswa)" value="{{ old('kelas') }}">
                </div>

                {{-- Password & Confirm --}}
                <div class="form-group row">
                  <div class="col-sm-6 mb-sm-0 mb-3">
                    <input name="password" type="password" class="form-control form-control-user" placeholder="Password"
                      required>
                  </div>
                  <div class="col-sm-6">
                    <input name="password_confirmation" type="password" class="form-control form-control-user"
                      placeholder="Ulangi Password" required>
                  </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Register Account
                </button>
              </form>

              <hr>
              <div class="text-center">
                <a class="small" href="{{ route('login') }}">Sudah punya akun? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
