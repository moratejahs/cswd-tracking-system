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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <style>
        body {
            background: linear-gradient(135deg, #435ebe 0%, #364574 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .logo-section {
            background: #f8f9fa;
            padding: 3rem 2rem;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .logo-section::after {
            content: '';
            position: absolute;
            bottom: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #435ebe20 0%, #36457420 100%);
            border-radius: 50%;
            z-index: 0;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e2e8f0;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #435ebe;
            box-shadow: 0 0 0 0.2rem rgba(67, 94, 190, 0.15);
            background: #ffffff;
        }

        .btn-primary {
            background: #435ebe;
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #364574;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 94, 190, 0.3);
        }

        .system-title {
            color: #1e1e1e;
            font-size: 1.4rem;
            font-weight: 600;
            margin-top: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .login-form-section {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #435ebe;
            margin-bottom: 0.5rem;
        }

        .alert {
            border-radius: 8px;
            border: none;
            background: #fee2e2;
            color: #991b1b;
            padding: 1rem;
        }

        .welcome-text {
            color: #6c757d;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-9 col-md-11 col-sm-12">
                <div class="login-card">
                    <div class="card-body p-0">
                        @if (session('error'))
                            <div class="alert m-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                        @endif
                        <form id="loginForm" action="{{ route('admin-login.submit') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="logo-section text-center">
                                        <img src="{{ asset('cswd_logo.png') }}" alt="CSWD Logo" width="110"
                                            class="mb-4">
                                        <h4 class="system-title">CSWD: AI Driven Assistant Tracking System</h4>
                                        <p class="welcome-text mt-3">Welcome back! Please login to access your
                                            dashboard.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="login-form-section">
                                        <h5 class="mb-4" style="color: #435ebe; font-weight: 600;">Admin Login</h5>
                                        <div class="mb-4">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username"
                                                placeholder="Enter your username" name="username" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" placeholder="Enter your password"
                                                class="form-control" id="password" name="password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Sign In</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/dark.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/horizontal.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
</body>

</html>
