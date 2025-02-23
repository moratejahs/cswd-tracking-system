<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('cswd_logo.png') }}" type="image/x-icon" />
    <title>CSWD Tracking System</title>

    <link rel="stylesheet" crossorigin href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/iconly.css') }}">

    <!-- JQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>


    <!-- </head> -->

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div>
                    <div class="card">
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-3"></i><span>{{ session('error') }}</span>
                                </div>
                            @endif
                            <form id="loginForm" action="{{ route('admin-login.submit') }}" method="POST">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-6">
                                        <div>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <img src="{{ asset('cswd_logo.png') }}" alt="CSWD Logo" width="100">
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <h4 class="text-center" style="font-family: 'Poppins', sans-serif;">
                                                    CSWD: AI Driven Assistant Tracking System</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <h5 style="font-family: 'Poppins', sans-serif;">
                                                Admin Login
                                            </h5>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label"
                                                style="font-family: 'Poppins', sans-serif;">Username</label>
                                            <input type="text" class="form-control" id="username"
                                                placeholder="Enter username" name="username" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="password" class="form-label"
                                                style="font-family: 'Poppins', sans-serif;">Password</label>
                                            <input type="password" placeholder="Enter password" class="form-control"
                                                id="password" name="password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100"
                                            style="font-family: 'Poppins', sans-serif;">Log In</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/dark.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/horizontal.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    {{--
    <script src="{{ asset('js/auth/login-form-validations.js') }}"></script> --}}
</body>

</html>