<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proyectos | Administración</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="resources/css/app.css">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="public/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    <link rel="stylesheet" href="{{asset('plugins/fullcalendar/main.css')}}">
    <!-- Hojas de estilos personalizados -->
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">

    @livewireStyles

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>
    -->

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-green elevation-4">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    @can('inicio')
                        <li class="nav-item">
                            <a href="{{url('/')}}"
                               class="{{ \Illuminate\Support\Facades\Route::is("inicio") ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Inicio</p>
                            </a>
                        </li>
                    @endcan
                    @can('usuarios')
                            <li class="nav-header">Administración</li>
                            <li class="nav-item">
                            <a href="{{url('usuarios')}}"
                               class="{{ \Illuminate\Support\Facades\Route::is("usuarios") ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                    @endcan
                        @can('personas')
                            <li class="nav-item">
                                <a href="{{url('personas')}}"
                                   class="{{ \Illuminate\Support\Facades\Route::is("personas") ? 'nav-link active' : 'nav-link' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Personas</p>
                                </a>
                            </li>
                        @endcan
                        @can('equipos')
                            <li class="nav-item">
                                <a href="{{url('equipos')}}"
                                   class="{{ \Illuminate\Support\Facades\Route::is("equipos") ? 'nav-link active' : 'nav-link' }}">
                                    <i class="nav-icon fas fa-people-carry"></i>
                                    <p>Equipos</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-header">Gestión de Proyectos</li>
                        @can('proyectos')
                            <li class="nav-item">
                                <a href="{{url('proyectos')}}"
                                   class="{{ \Illuminate\Support\Facades\Route::is("proyectos") ? 'nav-link active' : 'nav-link' }}">
                                    <i class="nav-icon fas fa-archive"></i>
                                    <p>Proyectos</p>
                                </a>
                            </li>
                        @endcan
                        @can('tareas')
                            <li class="nav-item">
                                <a href="{{url('tareas')}}"
                                   class="{{ \Illuminate\Support\Facades\Route::is("tareas") ? 'nav-link active' : 'nav-link' }}">
                                    <i class="nav-icon fas fa-clipboard-list"></i>
                                    <p>Tareas</p>
                                </a>
                            </li>
                        @endcan
                        @can('reportes')
                            <li class="nav-item">
                                <a href="{{url('reportes')}}"
                                   class="{{ \Illuminate\Support\Facades\Route::is("reportes") ? 'nav-link active' : 'nav-link' }}">
                                    <i class="nav-icon fas fa-file-archive"></i>
                                    <p>Reportes</p>
                                </a>
                            </li>
                        @endcan
                </ul>
                <footer class="nav-footer">
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        <li class="nav-item">
                            <a class="nav-link" type="button"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fas fa-door-closed btn-table-comment"></i><p> Cerrar Sesión</p>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </footer>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background: rgba(148,255,202,0.47)">
        <!-- Main content -->
        <section class="content small">
            @yield("content")
            @livewireScripts
            @stack('scripts')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<script type="text/javascript">

</script>
<!-- ./wrapper -->
<script src="{{asset('js/scripts.js')}}"></script>
<!-- App JS -->
<script src="resources/js/app.js"></script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="public/dist/js/adminlte.js"></script>
<!-- FullCalendar -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/main.js')}}"></script>

<script src="public/build/js/PushMenu.js"></script>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

</body>
</html>
