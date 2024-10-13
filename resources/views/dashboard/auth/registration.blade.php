<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="shortcut icon" href="https://img.icons8.com/external-vitaliy-gorbachev-flat-vitaly-gorbachev/58/external-atoms-university-vitaliy-gorbachev-flat-vitaly-gorbachev.png">
    <title>{{ config('app.name') }} registration</title>
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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
