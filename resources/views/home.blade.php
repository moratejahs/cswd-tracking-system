<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSWD Tracking System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('cswd_logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" crossorigin href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customize.css') }}">
    <link href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/extensions/aos/aos.css') }}" rel="stylesheet">


    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #435ebe;
            --secondary-color: #6c757d;
            --accent-color: #4CAF50;
            --bg-gradient: linear-gradient(135deg, #435ebe 0%, #364574 100%);
            --card-gradient: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        }

        body {
            font-family: "Poppins", sans-serif;
            background: #f8f9fa;
            color: #2b2b2b;
            min-height: 100vh;
            background: linear-gradient(135deg, #f6f8fd 0%, #f1f4f9 100%);
        }

        .header-top {
            background: var(--bg-gradient);
            padding: 1.2rem 0;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .header-top::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 60%);
            transform: rotate(45deg);
        }

        .logo a {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            text-decoration: none;
            position: relative;
            z-index: 1;
        }

        .logo img {
            width: 55px;
            height: auto;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        .logo span {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: 0.5px;
        }

        .container-fluid {
            padding: 3rem 4rem;
        }

        .main-title {
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 3rem;
            position: relative;
            padding-bottom: 1rem;
            text-align: center;
            font-weight: 600;
        }

        .main-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--accent-color) 100%);
            border-radius: 2px;
        }

        .card {
            border: none;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            margin-bottom: 2rem;
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--card-gradient);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(67, 94, 190, 0.15);
        }

        .card:hover::before {
            opacity: 1;
        }

        .card-header {
            background: var(--bg-gradient);
            padding: 2rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .card-header::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(50%, -50%);
        }

        .card-header h4 {
            color: #ffffff;
            font-size: 1.3rem;
            margin: 0;
            font-weight: 600;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
        }

        .card-body {
            padding: 2rem;
            background: #ffffff;
            position: relative;
            z-index: 1;
        }

        .card-body div {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
        }

        .card-body li {
            margin-bottom: 1rem;
            color: var(--secondary-color);
            list-style-type: none;
            position: relative;
            padding-left: 1.8rem;
            font-size: 0.95rem;
            line-height: 1.6;
            transition: all 0.3s ease;
        }

        .card-body li:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .card-body li::before {
            content: '→';
            color: var(--accent-color);
            font-size: 1.2rem;
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s ease;
        }

        .card-body li:hover::before {
            transform: translateY(-50%) translateX(3px);
        }

        .card-footer {
            background: rgba(248, 249, 250, 0.7);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.2rem 2rem;
            backdrop-filter: blur(5px);
        }

        .card-footer small {
            color: var(--secondary-color);
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        footer {
            background: var(--bg-gradient);
            padding: 2rem 0;
            margin-top: 4rem;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        footer p {
            color: #ffffff;
            margin: 0;
            font-size: 0.95rem;
            opacity: 0.9;
            text-align: center;
            position: relative;
            z-index: 1;
            letter-spacing: 0.5px;
        }

        /* Theme toggle enhancements */
        .theme-toggle {
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 30px;
            backdrop-filter: blur(5px);
        }

        .form-check-input {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .form-check-input:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        /* Dark mode enhancements */
        [data-bs-theme="dark"] {
            --bg-gradient: linear-gradient(135deg, #2b3553 0%, #1a1e2d 100%);
        }

        [data-bs-theme="dark"] body {
            background: linear-gradient(135deg, #1a1e2d 0%, #2b3553 100%);
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .card {
            background: rgba(43, 53, 83, 0.8);
            backdrop-filter: blur(10px);
        }

        [data-bs-theme="dark"] .card-body {
            background: transparent;
        }

        [data-bs-theme="dark"] .card-footer {
            background: rgba(26, 30, 45, 0.8);
            border-color: rgba(54, 69, 116, 0.2);
        }

        /* Animation enhancements */
        [data-aos] {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Responsive enhancements */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 2rem 1rem;
            }

            .main-title {
                font-size: 1.8rem;
            }

            .card-header h4 {
                font-size: 1.2rem;
            }

            .logo span {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    @include('admin.include.admin-store-category-modal')
    @include('admin.include.admin-add-product-stock-in-modal')
    @include('admin.include.admin-edit-product-stock-in-modal')
    @if (session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('message') }}',
                    showConfirmButton: false,
                    timer: 2000 // Adjust the duration as needed
                });
            });
        </script>
    @endif
    @if (session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: '{{ session('warning') }}',
                    showConfirmButton: false,
                    timer: 3000 // Adjust the duration as needed
                });
            });
        </script>
    @endif
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div class="header-top">
                    <div class="container">
                        <div class="logo d-flex">
                            <a href="{{ route('index.home') }}">
                                <img src="{{ asset('cswd_logo.png') }}" alt="Logo">
                                <span>
                                    <b>CSWD: AI Driven Assistant Tracking System</b>
                                    </sp>
                            </a>
                        </div>
                        <div class="header-top-right">
                            <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true" role="img" class="iconify iconify--system-uicons"
                                    width="20" height="20" preserveAspectRatio="xMidYMid meet"
                                    viewBox="0 0 21 21">
                                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                            opacity=".3"></path>
                                        <g transform="translate(-210 -1)">
                                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                            <circle cx="220.5" cy="11.5" r="4"></circle>
                                            <path
                                                d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                                <div class="form-check form-switch fs-6">
                                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                        style="cursor: pointer">
                                    <label class="form-check-label"></label>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
                                    height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                    </path>
                                </svg>
                            </div>
                            <div class="dropdown">

                            </div>

                            <!-- Burger button responsive -->
                            <a href="#" class="burger-btn d-block d-xl-none">
                                <i class="bi bi-justify fs-3"></i>
                            </a>
                        </div>
                    </div>
                </div>


            </header>

            <div class="container-fluid px-4">
                <h4 class="main-title">Requirements for CSWDO services vary depending on the type of assistance and
                    program.</h4>

                <div class="row" data-aos="fade-up" data-aos-duration="1000">
                    @foreach ($datas as $data)
                        <div class="col-lg-4 col-md-6 col-sm-12" data-aos="fade-up"
                            data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ $data->name }}</h4>
                                </div>
                                <div class="card-body">
                                    <div>Qualifications:</div>
                                    @foreach (explode('-', $data->description) as $item)
                                        @if (!empty(trim($item)))
                                            <li>{{ trim($item) }}</li>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="card-footer">
                                    <small>{{ $data->created_at->format('M d, Y') }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <footer>
                <div class="container">
                    <div class="clearfix mb-0 footer text-muted">
                        <div class="text-center">
                            <p>2025 &copy; CSWD: AI Driven Assistant Tracking System</p>
                        </div>
                        {{-- <div class="float-end">
                            <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></a></p>
                        </div> --}}
                    </div>
                </div>
            </footer>

            <!-- Logout Modal -->

        </div>
    </div>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/dark.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/horizontal.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('assets/extensions/aos/aos.js') }}"></script>
    <script>
        AOS.init();
    </script>
    {{--
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script> --}}
    {{--
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script> --}}
    @yield('scripts')
</body>

</html>
