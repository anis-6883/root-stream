<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html">
    <meta name="author" content="Muhammad Anisuzzaman">
    <meta name="description" content="Final Year Project">
    <meta name="keywords" content="Manage Live Match Streaming">
    <link rel="shortcut icon" href="{{ asset('public/default/favicon.png') }}"/>

    <title>RootStream</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/css/style.min.css') }}">
    <!-- fontawsome -->
    <script src="https://kit.fontawesome.com/fbcd216f09.js" crossorigin="anonymous"></script>
</head>

<body class="sidebar-dark">
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">
                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-8 col-xl-6 mx-auto">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-8 m-auto">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <a href="{{ url('/') }}" class="noble-ui-logo d-block mb-2 text-center"><img src="{{ asset('public/default/company.png') }}" alt="" width="300px"></a>
                                        {{-- <a href="#" class="noble-ui-logo d-block mb-2 text-center">Root<span>Stream</span></a> --}}
                                        <h5 class="text-muted fw-normal mb-4 text-center">Welcome Back! Login to Admin Account.</h5>
                                        <hr>
                                        <h4 class="text-muted mb-2 lead">Admin Login</h4>
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1"><i class='fas fa-envelope text-muted'></i></span>
                                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="userEmail" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1"><i class='fas fa-lock text-muted'></i></span>
                                                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="userPassword" autocomplete="current-password" placeholder="Password" required>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white w-100">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/backend/plugins/core/core.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/feather-icons/feather.min.js') }}"></script>
</body>
</html>
