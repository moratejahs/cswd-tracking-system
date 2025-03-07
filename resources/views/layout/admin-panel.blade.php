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
        body {
            font-family: "Poppins", serif;
            font-style: normal;
        }
    </style>

    @yield('links')
    @routes
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

                                <a href="#" id="topbarUserDropdown"
                                    class="user-dropdown d-flex align-items-center dropend dropdown-toggle "
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar avatar-md2">
                                        <img src="{{ asset('assets/images/profile/profile-img.png') }}" alt="Avatar">
                                    </div>
                                    <div class="text">
                                        <h6 class="user-dropdown-name">{{ auth()->user()->username }}</h6>
                                        <p class="text-sm user-dropdown-status text-muted">Admin</p>
                                    </div>
                                </a>
                                <ul class="shadow-lg dropdown-menu dropdown-menu-end"
                                    aria-labelledby="topbarUserDropdown">
                                    {{-- <li><a class="dropdown-item" href="#">My Account</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li> --}}
                                    <li><a class="dropdown-item text-danger" style="cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#logoutModal">Log
                                            Out</a></li>
                                </ul>
                            </div>

                            <!-- Burger button responsive -->
                            <a href="#" class="burger-btn d-block d-xl-none">
                                <i class="bi bi-justify fs-3"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <nav class="main-navbar">
                    <div class="container-fluid px-4">
                        <ul>
                            <li class="menu-item ">
                                <a href="{{ route('index.home') }}" class='menu-link'>
                                    <span><i class="bi bi-grid-fill"></i> Dashboard</span>
                                </a>
                            </li>

                            <li class="menu-item ">
                                <a href="{{ route('admin.manage_account.index') }}" class='menu-link'>
                                    <span><i class="bi bi-person-lines-fill"></i> Manage Accounts</span>
                                </a>
                            </li>

                            <li class="menu-item ">
                                <a href="{{ route('admin.assistance.index') }}" class='menu-link'>
                                    <span><i class="bi bi-box-fill"></i> Assistances</span>
                                </a>
                            </li>

                            <li class="menu-item ">
                                <a href="{{ route('admin.service.index') }}" class='menu-link'>
                                    <span><i class="bi bi-box-fill"></i> Services</span>
                                </a>
                            </li>

                            {{-- <li class="menu-item has-sub">
                                <a href="#" class='menu-link'>
                                    <span><i class="bi bi-box-fill"></i> Services</span>
                                </a>
                                <div class="submenu ">
                                    <div class="submenu-group-wrapper">
                                        <ul class="submenu-group">

                                            <li class="submenu-item ">
                                                <a href="{{ route('admin.assistance.index') }}" class='submenu-link'>
                                                    Assistances
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </nav>

            </header>

            <div class="container-fluid px-4">
                @yield('content')
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
            <div class="text-left modal fade modal-borderless" id="logoutModal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Log Out</h5>
                            <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to log out?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Stay</span>
                            </button>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Log Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
