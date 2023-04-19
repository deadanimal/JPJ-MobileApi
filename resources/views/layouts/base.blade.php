<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <link rel="icon" type="image/png" sizes="32x32" href="/">
    <title>Dasar Keselamatan - JPJ</title>
    <link href="/assets/fonts/eina/Eina03-Bold.ttf" rel="stylesheet">

    <!-- PICK ONE OF THE STYLES BELOW -->
    <!-- {{-- <link href="/assets/css/modern.css" rel="stylesheet"> --}} -->
    <!-- {{-- <link href="/assets/css/classic.css" rel="stylesheet"> --}} -->
    <!-- {{-- <link href="/assets/css/dark.css" rel="stylesheet"> --}} -->
    <link href="/assets/css/light.css" rel="stylesheet">


    <!-- BEGIN SETTINGS -->
    <!-- You can remove this after picking a style -->
    <style>
        @font-face {
            font-family: 'Eina03-bold';
            src: url('assets/fonts/eina/Eina03-Bold.ttf')
        }

        body {
            font-family: Eina03-bold;
            font-weight: normal;
            font-style: normal;
            padding: 0rem
        }

        .form-control {
            border-color: #4b3cbf;
            box-shadow: inset 2px 2px 5px 2px lightgrey;
        }

        .text-primary {
            color: #433395 !important;
        }

        .bg-primary {
            background-color: #4f3eca !important;
            color: white;
        }

        .bg-orange-cobkl {
            background-color: #3f1f9e;
        }

        .btn-orange-cobkl {
            color: white;
            background-color: #4c06c5;
        }

        .active1 {
            background-color: #E21118;
            border-radius: 5px;
        }

        .btn1:hover {
            background-color: #E21118;
            -webkit-text-fill-color: white;
        }

        .content {
            flex: 1;
            margin-top: 0rem;
            padding: 0rem
        }

        .vl {
            border-left: 2px solid green;
            height: 500px;
            position: relative;
            margin-left: -3px;
            bottom: 0;
        }

        .field-icon {
            float: right;
            margin-left: -25px;
            margin-right: 10px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
        }
    </style>
    <!-- END SETTINGS -->
</head>

<body>
    <div class="p-0">
        <img src="/img/jpj.png" style="background-color: rgb(7, 7, 108)" alt="DBKL" class="w-100">
    </div>
    <div class="main wrapper">
        <main class="content pb-5">
            <div class="splash active">
                <div class="splash-icon"></div>
            </div>

            <!-- <nav class="navbar navbar-expand-lg" style="background-color: white">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse">
                        @auth
                            <ul class="navbar-nav m-auto">
                                <li class="nav-item mr-auto">
                                    @if (Request::path() == '/')
                                        <a class="btn active1 text-white mx-3" href="/">Laman Utama</a>
                                    @else
                                        <a class="btn btn1 mx-3" href="/">Laman Utama</a>
                                    @endif
                                </li>
                                <li class="nav-item mr-auto">
                                    @if (Request::path() == 'mengenai-kami')
                                        <a class="btn active1 text-white mx-3" href="/#">Maklumat Korporat</a>
                                    @else
                                        <a class="btn btn1 mx-3" href="/#">Maklumat Korporat</a>
                                    @endif
                                </li>
                                <li class="nav-item mr-auto">
                                    @if (Request::path() == 'direktori')
                                        <a class="btn active1 text-white mx-3" href="/direktori">Pusat Media</a>
                                    @else
                                        <a class="btn btn1 mx-3" href="/direktori">Pusat Media</a>
                                    @endif
                                </li>
                                <li class="nav-item mr-auto">
                                    @if (Request::path() == 'soalan-lazim')
                                        <a class="btn active1 text-white mx-3" href="/soalan-lazim">Negeri</a>
                                    @else
                                        <a class="btn btn1 mx-3" href="soalan-lazim">Negeri</a>
                                    @endif
                                </li>
                                <li class="nav-item mr-auto">
                                    @if (Request::path() == 'pengumuman')
                                        <a class="btn active1 text-white mx-3" href="/pengumuman">Kategori</a>
                                    @else
                                        <a class="btn btn1 mx-3" href="/pengumuman">Kategori</a>
                                    @endif
                                </li>
                                <li class="nav-item dropdown mr-auto">
                                    @if (Request::path() == 'perkhidmatan-kami')
                                        <a class="btn active1 text-white mx-3" href="/perkhidmatan-kami">Hubungi Kami</a>
                                    @else
                                        <a class="btn btn1 mx-3" href="/perkhidmatan-kami">Hubungi Kami</a>
                                    @endif
                                </li>
                                <li class="nav-item mr-auto">
                                    @if (Route::has('login'))
                                        @auth
                                            <a class="btn active1 text-white mx-3" href="/perkhidmatan-kami"><i
                                                    class="far fa-user-circle fa-lg"></i>&nbsp;&nbsp;STAF</a>
                                        @else
                                            <a class="btn btn1 mx-3" type="button" data-bs-toggle="modal"
                                                data-bs-target="#modalLogin"><i
                                                    class="far fa-user-circle fa-lg"></i>&nbsp;&nbsp;LOG
                                                MASUK</a>
                                            <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        {{-- <div class="modal-header">
                                                <h5 class="modal-title">LOG MASUK</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div> --}}
                                                        <div class="modal-body m-5">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="modal-title">LOG MASUK</h5>
                                                                </div>
                                                                <div class="col text-end">
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                            </div>

                                                            <form action="">
                                                                <div class="mb-3">
                                                                    <label class="form-label">E-mel</label>
                                                                    <input type="email" class="form-control"
                                                                        placeholder="user@gmail.com">
                                                                </div>
                                                                <div class="mb-0">
                                                                    <label class="form-label">Kata Laluan</label>
                                                                    <input type="password" class="form-control"
                                                                        placeholder="Password" id="password-field">
                                                                    <span toggle="#password-field"
                                                                        class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                                </div>
                                                                <div class="text-end mb-3">
                                                                    <a href="/forgot-password" target="_blank"
                                                                        class="text-primary">Lupa
                                                                        Kata Laluan?</a>
                                                                </div>

                                                                <div class="mb-0">
                                                                    <a href="/login" class="btn btn-primary w-100">LOG
                                                                        MASUK</a>
                                                                </div>
                                                            </form>

                                                            <div class="mb-0 text-center">
                                                                <span class="text-sm">ATAU</span>
                                                            </div>

                                                            <div class="mb-1">
                                                                <a href="/register"
                                                                    class="btn btn-outline-primary w-100">DAFTAR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- @if (Route::has('register'))
                                            <a href="{{ route('register') }}"
                                                class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                                        @endif --}}
                                        @endauth
                                    @endif

                                </li>
                            </ul>
                        @else
                            <ul class="navbar-nav m-auto">
                                <li class="nav-item mr-auto">
                                    @if (Request::path() == '/')
                                        <a class="btn active1 text-white mx-3" href="/">Laman Utama</a>
                                    @else
                                        <a class="btn btn1 mx-3" href="/">Laman Utama</a>
                                    @endif
                                </li>
                                <li class="nav-item mr-auto">
                                    @if (Request::path() == 'mengenai-kami')
                                        <a class="btn active1 text-white mx-3" href="/#">Maklumat Korporat</a>
                                    @else
                                        <a class="btn btn1 mx-3" href="/#">Maklumat Korporat</a>
                                    @endif
                                </li>
                                <li class="nav-item mr-auto">
                                    @if (Request::path() == 'direktori')
                                        <a class="btn active1 text-white mx-3" href="/direktori">Pusat Media</a>
                                    @else
                                        <a class="btn btn1 mx-3" href="/direktori">Pusat Media</a>
                                    @endif
                                </li>
                                <li class="nav-item mr-auto">
                                    @if (Request::path() == 'soalan-lazim')
                                        <a class="btn active1 text-white mx-3" href="/soalan-lazim">Negeri</a>
                                    @else
                                        <a class="btn btn1 mx-3" href="soalan-lazim">Negeri</a>
                                    @endif
                                </li>
                                <li class="nav-item mr-auto">
                                    @if (Request::path() == 'pengumuman')
                                        <a class="btn active1 text-white mx-3" href="/pengumuman">Kategori</a>
                                    @else
                                        <a class="btn btn1 mx-3" href="/pengumuman">Kategori</a>
                                    @endif
                                </li>
                                <li class="nav-item dropdown mr-auto">
                                    @if (Request::path() == 'perkhidmatan-kami')
                                        <a class="btn active1 text-white mx-3" href="/perkhidmatan-kami">Hubungi Kami
                                            KAMI</a>
                                    @else
                                        <a class="btn btn1 mx-3" href="/perkhidmatan-kami">Hubungi Kami</a>
                                    @endif
                                </li>
                                <li class="nav-item mr-auto">
                                    @if (Route::has('login'))
                                        @auth
                                            <a class="btn active1 text-white mx-3" href="/perkhidmatan-kami"><i
                                                    class="far fa-user-circle fa-lg"></i>&nbsp;&nbsp;STAF</a>
                                        @else
                                            <a class="btn btn1 mx-3" type="button" data-bs-toggle="modal"
                                                data-bs-target="#modalLogin"><i
                                                    class="far fa-user-circle fa-lg"></i>&nbsp;&nbsp;LOG
                                                MASUK</a>
                                            <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        {{-- <div class="modal-header">
                                            <h5 class="modal-title">LOG MASUK</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div> --}}
                                                        <div class="modal-body m-5">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="modal-title">LOG MASUK</h5>
                                                                </div>
                                                                <div class="col text-end">
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                            </div>

                                                            <form action="">
                                                                <div class="mb-3">
                                                                    <label class="form-label">E-mel</label>
                                                                    <input type="email" class="form-control"
                                                                        placeholder="user@gmail.com">
                                                                </div>
                                                                <div class="mb-0">
                                                                    <label class="form-label">Kata Laluan</label>
                                                                    <input type="password" class="form-control"
                                                                        placeholder="Password" id="password-field">
                                                                    <span toggle="#password-field"
                                                                        class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                                </div>
                                                                <div class="text-end mb-3">
                                                                    <a href="/forgot-password" target="_blank"
                                                                        class="text-primary">Lupa
                                                                        Kata Laluan?</a>
                                                                </div>

                                                                <div class="mb-0">
                                                                    <a href="/login" class="btn btn-primary w-100">LOG
                                                                        MASUK</a>
                                                                </div>
                                                            </form>

                                                            <div class="mb-0 text-center">
                                                                <span class="text-sm">ATAU</span>
                                                            </div>

                                                            <div class="mb-1">
                                                                <a href="/register"
                                                                    class="btn btn-outline-primary w-100">DAFTAR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                            class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                                    @endif --}}
                                        @endauth
                                    @endif

                                </li>
                            </ul>
                        @endauth
                    </div>
                </div>
            </nav> -->

            @yield('sambungan')
        </main>

        <footer class="footer" style="background-color: #312C82">
            <div class="container-fluid">
                <div class="row text-white">
                    <div class="col-6">
                        <ul class="list-inline" style="margin-left: 7rem">
                            <li class="list-inline-item">
                                <!-- <a class="text-white" href="#">Info Korporat</a> -->
                            </li>
                            <li class="list-inline-item">
                                <!-- <a class="text-white" href="#">Laman Web Kerajaan</a> -->
                            </li>
                            <li class="list-inline-item">
                                <!-- <a class="text-white" href="#">Hubungi Kami</a> -->
                            </li>
                            <!-- <li class="list-inline-item">
                                <a class="text-white" href="#">Contact</a>
                            </li> -->
                        </ul>
                    </div>
                    <div class="col-6">
                        <p class="mb-0" style="margin-left: 7rem">
                            Hakcipta &copy; 2022 JPJ. Hak cipta terpelihara. 
                             <!-- <a href="dashboard-default.html" class="text-white">COBKL</a> -->
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- {{-- <div class="wrapper"> --}} -->
    <!--{{-- <nav id="sidebar" class="sidebar">
            <a class="sidebar-brand" href="/">
                <img src="/img/dbkl.png" alt="DBKL" style="width: 80px">
                COB - DBKL
            </a>
            <div class="sidebar-content">
                <div class="sidebar-user">
                    <img src="/assets/img/avatars/avatar.jpg" class="img-fluid rounded-circle mb-2"
                        alt="Linda Miller" />
                    <div class="fw-bold">Linda Miller</div>
                    <small>Front-end Developer</small>
                </div>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Main
                    </li>
                    <li class="sidebar-item active">
                        <a data-bs-target="#dashboards" data-bs-toggle="collapse" class="sidebar-link">
                            <i class="align-middle me-2 fas fa-fw fa-home"></i> <span
                                class="align-middle">Dashboards</span>
                        </a>
                        <ul id="dashboards" class="sidebar-dropdown list-unstyled collapse show"
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item active"><a class="sidebar-link"
                                    href="dashboard-default.html">Default</a></li>
                            <li class="sidebar-item"><a class="sidebar-link"
                                    href="dashboard-analytics.html">Analytics</a></li>
                            <li class="sidebar-item"><a class="sidebar-link"
                                    href="dashboard-e-commerce.html">E-commerce</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#pages" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle me-2 fas fa-fw fa-file"></i> <span
                                class="align-middle">Pages</span>
                        </a>
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse "
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-settings.html">Settings</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-clients.html">Clients <span
                                        class="sidebar-badge badge rounded-pill bg-primary">New</span></a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-invoice.html">Invoice</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-pricing.html">Pricing</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-tasks.html">Tasks</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-chat.html">Chat <span
                                        class="sidebar-badge badge rounded-pill bg-primary">New</span></a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-blank.html">Blank Page</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#auth" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle me-2 fas fa-fw fa-sign-in-alt"></i> <span
                                class="align-middle">Auth</span>
                        </a>
                        <ul id="auth" class="sidebar-dropdown list-unstyled collapse "
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-sign-in.html">Sign
                                    In</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-sign-up.html">Sign
                                    Up</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-reset-password.html">Reset
                                    Password</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-404.html">404
                                    Page</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="pages-500.html">500
                                    Page</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-header">
                        Elements
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#ui" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle me-2 fas fa-fw fa-flask"></i> <span class="align-middle">User
                                Interface</span>
                        </a>
                        <ul id="ui" class="sidebar-dropdown list-unstyled collapse "
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class="sidebar-link" href="ui-alerts.html">Alerts</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="ui-buttons.html">Buttons</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="ui-cards.html">Cards</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="ui-general.html">General</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="ui-grid.html">Grid</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link" href="ui-modals.html">Modals</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="ui-offcanvas.html">Offcanvas</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link"
                                    href="ui-notifications.html">Notifications</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="ui-tabs.html">Tabs</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link" href="ui-typography.html">Typography</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#charts" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle me-2 fas fa-fw fa-chart-pie"></i> <span
                                class="align-middle">Charts</span>
                            <span class="sidebar-badge badge rounded-pill bg-primary">New</span>
                        </a>
                        <ul id="charts" class="sidebar-dropdown list-unstyled collapse "
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class="sidebar-link" href="charts-chartjs.html">Chart.js</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link"
                                    href="charts-apexcharts.html">ApexCharts</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a data-bs-target="#forms" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle me-2 fas fa-fw fa-check-square"></i> <span
                                class="align-middle">Forms</span>
                        </a>
                        <ul id="forms" class="sidebar-dropdown list-unstyled collapse "
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class="sidebar-link" href="forms-layouts.html">Layouts</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link" href="forms-basic-elements.html">Basic
                                    Elements</a></li>
                            <li class="sidebar-item"><a class="sidebar-link"
                                    href="forms-advanced-elements.html">Advanced Elements</a></li>
                            <li class="sidebar-item"><a class="sidebar-link"
                                    href="forms-floating-labels.html">Floating Labels</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="forms-input-groups.html">Input
                                    Groups</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="forms-editors.html">Editors</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link"
                                    href="forms-validation.html">Validation</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="forms-wizard.html">Wizard</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#tables" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle me-2 fas fa-fw fa-table"></i> <span
                                class="align-middle">Tables</span>
                        </a>
                        <ul id="tables" class="sidebar-dropdown list-unstyled collapse "
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class="sidebar-link"
                                    href="tables-bootstrap.html">Bootstrap</a></li>
                            <li class="sidebar-item"><a class="sidebar-link"
                                    href="tables-datatables.html">DataTables</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#icons" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle me-2 fas fa-fw fa-heart"></i> <span
                                class="align-middle">Icons</span>
                        </a>
                        <ul id="icons" class="sidebar-dropdown list-unstyled collapse "
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class="sidebar-link" href="icons-feather.html">Feather</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link" href="icons-ion.html">Ion
                                    Icons</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="icons-font-awesome.html">Font
                                    Awesome</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="calendar.html">
                            <i class="align-middle me-2 far fa-fw fa-calendar-alt"></i> <span
                                class="align-middle">Calendar</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#maps" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle me-2 fas fa-fw fa-map-marker-alt"></i> <span
                                class="align-middle">Maps</span>
                        </a>
                        <ul id="maps" class="sidebar-dropdown list-unstyled collapse "
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class="sidebar-link" href="maps-google.html">Google Maps</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link" href="maps-vector.html">Vector Maps</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-header">
                        Extras
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#documentation" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle me-2 fas fa-fw fa-book"></i> <span
                                class="align-middle">Documentation</span>
                        </a>
                        <ul id="documentation" class="sidebar-dropdown list-unstyled collapse "
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class="sidebar-link" href="docs-getting-started.html">Getting
                                    Started</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="docs-plugins.html">Plugins</a>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link" href="docs-changelog.html">Changelog</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#layouts" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle me-2 fas fa-fw fa-desktop"></i> <span
                                class="align-middle">Layouts</span>
                        </a>
                        <ul id="layouts" class="sidebar-dropdown list-unstyled collapse "
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item"><a class="sidebar-link" href="layouts-sidebar-left.html">Left
                                    Sidebar</a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="layouts-sidebar-right.html">Right
                                    Sidebar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav> --}} -->
    <!--{{-- <div class="main">
            <nav class="navbar navbar-expand navbar-theme">
                <a class="sidebar-toggle d-flex me-2">
                    <i class="hamburger align-self-center"></i>
                </a>

                <form class="d-none d-sm-inline-block">
                    <input class="form-control form-control-lite" type="text" placeholder="Search projects...">
                </form>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle position-relative" href="#"
                                id="messagesDropdown" data-bs-toggle="dropdown">
                                <i class="align-middle fas fa-envelope-open"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                                aria-labelledby="messagesDropdown">
                                <div class="dropdown-menu-header">
                                    <div class="position-relative">
                                        4 New Messages
                                    </div>
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="/assets/img/avatars/avatar-5.jpg"
                                                    class="avatar img-fluid rounded-circle" alt="Michelle Bilodeau">
                                            </div>
                                            <div class="col-10 ps-2">
                                                <div class="text-dark">Michelle Bilodeau</div>
                                                <div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis
                                                    arcu tortor.</div>
                                                <div class="text-muted small mt-1">5m ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="/assets/img/avatars/avatar-3.jpg"
                                                    class="avatar img-fluid rounded-circle" alt="Kathie Burton">
                                            </div>
                                            <div class="col-10 ps-2">
                                                <div class="text-dark">Kathie Burton</div>
                                                <div class="text-muted small mt-1">Pellentesque auctor neque nec urna.
                                                </div>
                                                <div class="text-muted small mt-1">30m ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="/assets/img/avatars/avatar-2.jpg"
                                                    class="avatar img-fluid rounded-circle" alt="Alexander Groves">
                                            </div>
                                            <div class="col-10 ps-2">
                                                <div class="text-dark">Alexander Groves</div>
                                                <div class="text-muted small mt-1">Curabitur ligula sapien euismod
                                                    vitae.</div>
                                                <div class="text-muted small mt-1">2h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="/assets/img/avatars/avatar-4.jpg"
                                                    class="avatar img-fluid rounded-circle" alt="Daisy Seger">
                                            </div>
                                            <div class="col-10 ps-2">
                                                <div class="text-dark">Daisy Seger</div>
                                                <div class="text-muted small mt-1">Aenean tellus metus, bibendum sed,
                                                    posuere ac, mattis non.</div>
                                                <div class="text-muted small mt-1">5h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all messages</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle position-relative" href="#" id="alertsDropdown"
                                data-bs-toggle="dropdown">
                                <i class="align-middle fas fa-bell"></i>
                                <span class="indicator"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                                aria-labelledby="alertsDropdown">
                                <div class="dropdown-menu-header">
                                    4 New Notifications
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="ms-1 text-danger fas fa-fw fa-bell"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Update completed</div>
                                                <div class="text-muted small mt-1">Restart server 12 to complete the
                                                    update.</div>
                                                <div class="text-muted small mt-1">2h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="ms-1 text-warning fas fa-fw fa-envelope-open"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Lorem ipsum</div>
                                                <div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate
                                                    hendrerit et.</div>
                                                <div class="text-muted small mt-1">6h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="ms-1 text-primary fas fa-fw fa-building"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Login from 192.186.1.1</div>
                                                <div class="text-muted small mt-1">8h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="ms-1 text-success fas fa-fw fa-bell-slash"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">New connection</div>
                                                <div class="text-muted small mt-1">Anna accepted your request.</div>
                                                <div class="text-muted small mt-1">12h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all notifications</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle position-relative" href="#" id="userDropdown"
                                data-bs-toggle="dropdown">
                                <i class="align-middle fas fa-cog"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#"><i
                                        class="align-middle me-1 fas fa-fw fa-user"></i> View Profile</a>
                                <a class="dropdown-item" href="#"><i
                                        class="align-middle me-1 fas fa-fw fa-comments"></i> Contacts</a>
                                <a class="dropdown-item" href="#"><i
                                        class="align-middle me-1 fas fa-fw fa-chart-pie"></i> Analytics</a>
                                <a class="dropdown-item" href="#"><i
                                        class="align-middle me-1 fas fa-fw fa-cogs"></i> Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i
                                        class="align-middle me-1 fas fa-fw fa-arrow-alt-circle-right"></i> Sign out</a>
                            </div>
                        </li>
                    </ul>
                </div>

            </nav>
            <main class="content">
                <div class="container-fluid">

                    <div class="header">
                        <h1 class="header-title">
                            Welcome back, Linda!
                        </h1>
                        <p class="header-subtitle">You have 24 new messages and 5 new notifications.</p>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 col-xxl-7">
                            <div class="card flex-fill w-100">
                                <div class="card-header">
                                    <div class="card-actions float-end">
                                        <a href="#" class="me-1">
                                            <i class="align-middle" data-feather="refresh-cw"></i>
                                        </a>
                                        <div class="d-inline-block dropdown show">
                                            <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                                <i class="align-middle" data-feather="more-vertical"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="card-title mb-0">Recent Movement</h5>
                                </div>
                                <div class="card-body py-3">
                                    <div class="chart chart-sm">
                                        <canvas id="chartjs-dashboard-line"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-xxl-5 d-flex">
                            <div class="w-100">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Sales Today</h5>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="avatar">
                                                            <div class="avatar-title rounded-circle bg-primary-dark">
                                                                <i class="align-middle" data-feather="truck"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="display-5 mt-1 mb-3">2.562</h1>
                                                <div class="mb-0">
                                                    <span class="text-danger"> <i
                                                            class="mdi mdi-arrow-bottom-right"></i> -2.65% </span>
                                                    Less sales than usual
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Visitors Today</h5>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="avatar">
                                                            <div class="avatar-title rounded-circle bg-primary-dark">
                                                                <i class="align-middle" data-feather="users"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="display-5 mt-1 mb-3">17.212</h1>
                                                <div class="mb-0">
                                                    <span class="text-success"> <i
                                                            class="mdi mdi-arrow-bottom-right"></i> 5.50% </span>
                                                    More visitors than usual
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Total Earnings</h5>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="avatar">
                                                            <div class="avatar-title rounded-circle bg-primary-dark">
                                                                <i class="align-middle"
                                                                    data-feather="dollar-sign"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="display-5 mt-1 mb-3">$24.300</h1>
                                                <div class="mb-0">
                                                    <span class="text-success"> <i
                                                            class="mdi mdi-arrow-bottom-right"></i> 8.35% </span>
                                                    More earnings than usual
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Pending Orders</h5>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="avatar">
                                                            <div class="avatar-title rounded-circle bg-primary-dark">
                                                                <i class="align-middle"
                                                                    data-feather="shopping-cart"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="display-5 mt-1 mb-3">43</h1>
                                                <div class="mb-0">
                                                    <span class="text-danger"> <i
                                                            class="mdi mdi-arrow-bottom-right"></i> -4.25% </span>
                                                    Less orders than usual
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
                            <div class="card flex-fill">
                                <div class="card-header">
                                    <div class="card-actions float-end">
                                        <a href="#" class="me-1">
                                            <i class="align-middle" data-feather="refresh-cw"></i>
                                        </a>
                                        <div class="d-inline-block dropdown show">
                                            <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                                <i class="align-middle" data-feather="more-vertical"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="card-title mb-0">Calendar</h5>
                                </div>
                                <div class="card-body d-flex">
                                    <div class="align-self-center w-100">
                                        <div class="chart">
                                            <div id="datetimepicker-dashboard"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-xxl-6 d-flex order-3 order-xxl-2">
                            <div class="card flex-fill w-100">
                                <div class="card-header">
                                    <div class="card-actions float-end">
                                        <a href="#" class="me-1">
                                            <i class="align-middle" data-feather="refresh-cw"></i>
                                        </a>
                                        <div class="d-inline-block dropdown show">
                                            <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                                <i class="align-middle" data-feather="more-vertical"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="card-title mb-0">Current Visitors</h5>
                                </div>
                                <div class="card-body px-4">
                                    <div id="world_map" style="height:350px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
                            <div class="card flex-fill w-100">
                                <div class="card-header">
                                    <div class="card-actions float-end">
                                        <a href="#" class="me-1">
                                            <i class="align-middle" data-feather="refresh-cw"></i>
                                        </a>
                                        <div class="d-inline-block dropdown show">
                                            <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                                <i class="align-middle" data-feather="more-vertical"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="card-title mb-0">Browser Usage</h5>
                                </div>
                                <div class="card-body d-flex">
                                    <div class="align-self-center w-100">
                                        <div class="py-3">
                                            <div class="chart chart-xs">
                                                <canvas id="chartjs-dashboard-pie"></canvas>
                                            </div>
                                        </div>

                                        <table class="table mb-0">
                                            <tbody>
                                                <tr>
                                                    <td><i class="fas fa-circle text-primary fa-fw"></i> Chrome</td>
                                                    <td class="text-end">4401</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fas fa-circle text-warning fa-fw"></i> Firefox</td>
                                                    <td class="text-end">4003</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fas fa-circle text-danger fa-fw"></i> IE</td>
                                                    <td class="text-end">1589</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-8 col-xxl-9 d-flex">
                            <div class="card flex-fill">
                                <div class="card-header">
                                    <div class="card-actions float-end">
                                        <a href="#" class="me-1">
                                            <i class="align-middle" data-feather="refresh-cw"></i>
                                        </a>
                                        <div class="d-inline-block dropdown show">
                                            <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                                <i class="align-middle" data-feather="more-vertical"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="card-title mb-0">Latest Projects</h5>
                                </div>
                                <table id="datatables-dashboard-projects" class="table table-striped my-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="d-none d-xl-table-cell">Start Date</th>
                                            <th class="d-none d-xl-table-cell">End Date</th>
                                            <th>Status</th>
                                            <th class="d-none d-md-table-cell">Assignee</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Project Apollo</td>
                                            <td class="d-none d-xl-table-cell">01/01/2021</td>
                                            <td class="d-none d-xl-table-cell">31/06/2021</td>
                                            <td><span class="badge bg-success">Done</span></td>
                                            <td class="d-none d-md-table-cell">Carl Jenkins</td>
                                        </tr>
                                        <tr>
                                            <td>Project Fireball</td>
                                            <td class="d-none d-xl-table-cell">01/01/2021</td>
                                            <td class="d-none d-xl-table-cell">31/06/2021</td>
                                            <td><span class="badge bg-danger">Cancelled</span></td>
                                            <td class="d-none d-md-table-cell">Bertha Martin</td>
                                        </tr>
                                        <tr>
                                            <td>Project Hades</td>
                                            <td class="d-none d-xl-table-cell">01/01/2021</td>
                                            <td class="d-none d-xl-table-cell">31/06/2021</td>
                                            <td><span class="badge bg-success">Done</span></td>
                                            <td class="d-none d-md-table-cell">Stacie Hall</td>
                                        </tr>
                                        <tr>
                                            <td>Project Nitro</td>
                                            <td class="d-none d-xl-table-cell">01/01/2021</td>
                                            <td class="d-none d-xl-table-cell">31/06/2021</td>
                                            <td><span class="badge bg-warning">In progress</span></td>
                                            <td class="d-none d-md-table-cell">Carl Jenkins</td>
                                        </tr>
                                        <tr>
                                            <td>Project Phoenix</td>
                                            <td class="d-none d-xl-table-cell">01/01/2021</td>
                                            <td class="d-none d-xl-table-cell">31/06/2021</td>
                                            <td><span class="badge bg-success">Done</span></td>
                                            <td class="d-none d-md-table-cell">Bertha Martin</td>
                                        </tr>
                                        <tr>
                                            <td>Project X</td>
                                            <td class="d-none d-xl-table-cell">01/01/2021</td>
                                            <td class="d-none d-xl-table-cell">31/06/2021</td>
                                            <td><span class="badge bg-success">Done</span></td>
                                            <td class="d-none d-md-table-cell">Stacie Hall</td>
                                        </tr>
                                        <tr>
                                            <td>Project Romeo</td>
                                            <td class="d-none d-xl-table-cell">01/01/2021</td>
                                            <td class="d-none d-xl-table-cell">31/06/2021</td>
                                            <td><span class="badge bg-success">Done</span></td>
                                            <td class="d-none d-md-table-cell">Ashley Briggs</td>
                                        </tr>
                                        <tr>
                                            <td>Project Wombat</td>
                                            <td class="d-none d-xl-table-cell">01/01/2021</td>
                                            <td class="d-none d-xl-table-cell">31/06/2021</td>
                                            <td><span class="badge bg-warning">In progress</span></td>
                                            <td class="d-none d-md-table-cell">Bertha Martin</td>
                                        </tr>
                                        <tr>
                                            <td>Project Zircon</td>
                                            <td class="d-none d-xl-table-cell">01/01/2021</td>
                                            <td class="d-none d-xl-table-cell">31/06/2021</td>
                                            <td><span class="badge bg-danger">Cancelled</span></td>
                                            <td class="d-none d-md-table-cell">Stacie Hall</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-xxl-3 d-flex">
                            <div class="card flex-fill w-100">
                                <div class="card-header">
                                    <div class="card-actions float-end">
                                        <a href="#" class="me-1">
                                            <i class="align-middle" data-feather="refresh-cw"></i>
                                        </a>
                                        <div class="d-inline-block dropdown show">
                                            <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                                <i class="align-middle" data-feather="more-vertical"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="card-title mb-0">Monthly Sales</h5>
                                </div>
                                <div class="card-body d-flex w-100">
                                    <div class="align-self-center chart chart-lg">
                                        <canvas id="chartjs-dashboard-bar"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-8 text-start">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Terms of Service</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Contact</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-4 text-end">
                            <p class="mb-0">
                                &copy; 2021 - <a href="dashboard-default.html" class="text-muted">Spark</a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div> --}}-->
    <!-- {{-- </div> --}} -->
    <script src="/assets/js/app.js"></script>


    <script>
        $(function() {
            $('#datatables-dashboard-projects').DataTable({
                pageLength: 6,
                lengthChange: false,
                bFilter: false,
                autoWidth: false
            });
        });
    </script>
    <script>
        $(function() {
            $('#datetimepicker-dashboard').datetimepicker({
                inline: true,
                sideBySide: false,
                format: 'L'
            });
        });
    </script>
    <script>
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>

</body>

</html>
