<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="shortcut icon" href="https://img.icons8.com/external-vitaliy-gorbachev-flat-vitaly-gorbachev/58/external-atoms-university-vitaliy-gorbachev-flat-vitaly-gorbachev.png">
    <title>{{ config('app.name') }} Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&amp;family=Nunito+Sans:ital,opsz,wght@0,6..12,200;0,6..12,300;0,6..12,400;0,6..12,500;0,6..12,600;0,6..12,700;0,6..12,800;0,6..12,900;0,6..12,1000;1,6..12,200;1,6..12,300;1,6..12,400;1,6..12,500;1,6..12,600;1,6..12,700;1,6..12,800;1,6..12,900;1,6..12,1000&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/vendors/icofont.css">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/vendors/themify.css">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/vendors/flag-icon.css">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/style.css">
    <link id="color" rel="stylesheet" href="https://admin.pixelstrap.com/cion/assets/css/color-1.css" media="screen">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/responsive.css">
    <link rel="shortcut icon" type="image/x-icon" href="{{ route('view-image', ['m' => 'Setting', 'id' => 0, 'nameVar'=> 'logo']) }}">
</head>
  <body>
        <!-- login page start-->
        <div class="container-fluid p-0">
            <div class="row m-0">
              <div class="col-12 p-0">
                <div class="login-card login-dark" style="background-image: url('https://cutewallpaper.org/21/cryptocurrency-wallpaper-hd/Why-is-Malwarebytes-blocking-Coinhive-Malwarebytes-Labs-.jpg');">
                  <div>
                    <div>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

                    </div>
                    <div class="login-main">
                        <form class="theme-form" method="POST" action="{{ route('login.custom') }}">
                        @csrf
                        <h3>Sign in to account</h3>
                        <p>Enter your email & password to login</p>
                        <a class="logo" href=""><img class="img-fluid for-light" src="{{ asset('storage' . ($settings['logo'] ?? 'default-logo.png')) }}" alt="looginpage" width="60%"><img class="img-fluid for-dark" src="/logo.png"  width="10%" alt="looginpage"></a>

                        <div class="form-group">
                            <label for="emailaddress">Email address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group">
                            <a href="pages-recoverpw.html" class="text-muted float-right"><small>Forgot your password?</small></a>
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}  class="custom-control-input">
                                <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                          <div class="text-end mt-3">
                            <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                          </div>
                        </div>
                        <br>
         
                      </form>
                    </div>
                  </div>
                </div>
              </div>

            </div>
        </div>
        <footer class="footer footer-alt">
            <p class="text-muted">The final version issuance No. 3.1 Developer By <a href="{{ config('developer.link') }}">{{ config('developer.name') }}</a></p>
            <script>document.write(new Date().getFullYear())</script>
        </footer>

</body>