<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>.:CANAZATEL:.</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/bower_components/animate-css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('template/bower_components/select2/dist/css/select2.min.css') }}">

    <script src="{{ asset('template/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        .modal-body { margin-right: 20px; margin-left: 20px; }
        .select2-selection__choice { background-color: #222222 !important; }
        .a-li { padding-top: 6px !important; padding-bottom: 6px !important; }
        .alert { z-index: 9999 !important; }
    </style>
    @yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <a href="#" class="logo">
            <span class="logo-mini"><b>CZT</b></span>
            <span class="logo-lg"><b>Canazatel</b></span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    @hasanyrole('ADMINISTRADOR|SUPER_ADMIN|GERENCIA GENERAL')
                    @php
                        $solicitudes_m = \App\Models\Solicitud::join('sucursal', 'sucursal.ID_SUC', '=', 'solicitud.ID_SUC')
                            ->where('EST_SOL', 'PENDIENTE')
                            ->get();
                        $numero_s = $solicitudes_m->count();
                    @endphp
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-danger">{{ $numero_s != 0 ? $numero_s : '' }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Hay {{ $numero_s }} solicitudes</li>
                            <li>
                                <ul class="menu">
                                    @foreach ($solicitudes_m as $sol)
                                        <li>
                                            <a href="#">
                                                {{ $sol->NOM_SUC }} | {{ $sol->FEC_SOL.' '.$sol->HOR_SOL }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endhasanyrole

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ url('img/user.jpg') }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ trim((Auth::user()->NOM_USU ?? Auth::user()->name ?? '').' '.(Auth::user()->PAT_USU ?? '')) ?: (Auth::user()->email ?? '') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="{{ url('img/user.jpg') }}" class="img-circle" alt="User Image">
                                <p>
                                    {{ trim((Auth::user()->NOM_USU ?? Auth::user()->name ?? '').' '.(Auth::user()->PAT_USU ?? '')) ?: (Auth::user()->email ?? '') }}
                                    <small>{{ Auth::user()->created_at }}</small>
                                </p>
                            </li>
                            <li class="user-footer" style="background-color: #6F6F6F;">
                                <div class="pull-left">
                                    <button type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modalPass">Cambiar Contraseña</button>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Salir</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ url('img/user.jpg') }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ trim((Auth::user()->NOM_USU ?? Auth::user()->name ?? '').' '.(Auth::user()->PAT_USU ?? '')) ?: (Auth::user()->email ?? '') }}</p>
                    @php $rolAuth = Auth::user()->roles ?? collect(); @endphp
                    <a href="#"><i class="fa fa-circle text-success"></i>
                        @foreach ($rolAuth as $role_auth)
                            {{ $role_auth->name }}
                        @endforeach
                    </a>
                </div>
            </div>

            <ul class="sidebar-menu" data-widget="tree">
                <li class="@yield('inicio')"><a class="a-li" href="{{ url('/inicio') }}"><i class="fa fa-home"></i> <span>INICIO</span></a></li>
                <li class="@yield('configuracion')"><a class="a-li" href="{{ url('/configuracion') }}"><i class="fa fa-cog"></i> <span>CONFIGURACION</span></a></li>
                <li class="@yield('usuario')"><a class="a-li" href="{{ url('/usuario') }}"><i class="fa fa-user"></i> <span>USUARIOS</span></a></li>
                <li class="@yield('rol')"><a class="a-li" href="{{ url('/rol') }}"><i class="fa fa-random"></i> <span>ROLES Y PERMISOS</span></a></li>
                <li class="@yield('localidad')"><a class="a-li" href="{{ url('/localidad') }}"><i class="fa fa-map-o"></i> <span>LOCALIDADES</span></a></li>
                <li class="@yield('sucursal')"><a class="a-li" href="{{ url('/sucursal') }}"><i class="fa fa-university"></i> <span>SUCURSALES</span></a></li>
                <li class="@yield('plan')"><a class="a-li" href="{{ url('/plan') }}"><i class="fa fa-cubes"></i> <span>PLANES</span></a></li>
                <li class="@yield('canal')"><a class="a-li" href="{{ url('/canal') }}"><i class="fa fa-cube"></i> <span>CANALES</span></a></li>
                <li class="@yield('cliente')"><a class="a-li" href="{{ url('/cliente') }}"><i class="fa fa-users"></i> <span>CLIENTES</span></a></li>
                <li class="@yield('material')"><a class="a-li" href="{{ url('/material') }}"><i class="fa fa-tags"></i> <span>MATERIALES</span></a></li>
                <li class="@yield('solicitud')"><a class="a-li" href="{{ url('/solicitud') }}"><i class="fa fa-share-alt"></i> <span>SOLICITUDES</span></a></li>
                <li class="@yield('gasto')"><a class="a-li" href="{{ url('/gasto') }}"><i class="fa fa-shopping-cart"></i> <span>GASTOS</span></a></li>
                <li class="@yield('reporte')"><a class="a-li" href="{{ url('/reporte') }}"><i class="fa fa-copy"></i> <span>REPORTES</span></a></li>
                <li class="@yield('alerta')"><a class="a-li" href="{{ url('/alerta') }}"><i class="fa fa-exclamation-triangle"></i> <span>ALERTAS</span></a></li>
                <li class="@yield('asignacion')"><a class="a-li" href="{{ url('/asignacion') }}"><i class="fa fa-check-square-o"></i> <span>ASIGNAR TECNICOS</span></a></li>
                @can('WEB')
                <li class="treeview @yield('menu-open')">
                    <a class="a-li" href="#">
                        <i class="fa fa-internet-explorer"></i> <span>Web</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu" @yield('tree-web')>
                        <li class="@yield('solicitud-web')"><a href="{{ url('/solicitudWeb') }}"><i class="fa fa-circle-o"></i> Solicitudes</a></li>
                        <li class="@yield('reclamo')"><a href="{{ url('/reclamo') }}"><i class="fa fa-circle-o"></i> Reclamos</a></li>
                    </ul>
                </li>
                @endcan
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@yield('title') <small>@yield('caption')</small></h1>
        </section>

        <section class="content">
            @if (session()->has('exito'))
                <script>$(function(){ success_message(@json(session('exito'))); });</script>
            @endif
            @if (session()->has('error'))
                <script>$(function(){ error_message(@json(session('error'))); });</script>
            @endif
            @yield('content')
        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs"><b>Version</b> 1.0.0</div>
        <strong>Copyright &copy; {{ date('Y') }} <a href="#">Canazatel</a>.</strong> Todos los derechos reservados.
    </footer>

    <div class="modal fade" id="modalPass" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">CAMBIO DE CONTRASEÑA</h4>
                </div>
                <div class="box-body" style="margin-left: 20px; margin-right: 20px;">
                    <div class="row">
                        <form method="POST" action="{{ route('usuario.password') }}" data-parsley-validate>
                            @csrf
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password_act">Ingrese su contraseña actual:</label>
                                    <input type="password" class="form-control" id="password_act" name="password_act" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password_new">Ingrese su nueva contraseña:</label>
                                    <input type="password" class="form-control" id="password_new" name="password_new" onkeyup="passVerifica()" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password_rep">Repita su nueva contraseña:</label>
                                    <input type="password" class="form-control" id="password_rep" name="password_rep" onkeyup="passVerifica()" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="modal-footer" style="margin-right: 0; margin-left: 0; padding-right: 0; padding-left: 0;">
                                    <button type="submit" class="btn btn-primary pull-right" id="btnPassword"><i class="fa fa-check"></i> CAMBIAR CONTRASEÑA</button>
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="control-sidebar-bg"></div>
</div>

<script src="{{ asset('template/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('template/dist/js/demo.js') }}"></script>
<script src="{{ asset('template/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('template/bower_components/notifications/bootstrap-notify.js') }}"></script>
<script src="{{ asset('template/bower_components/parsley/parsley.js') }}"></script>
<script src="{{ asset('template/bower_components/validacion/mivalidacion.js') }}"></script>
<script src="{{ asset('template/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<script>
    $(function () {
        $('.sidebar-menu').tree();

        $('.datatable').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false
        });
    });

    function success_message(mensaje){
        $.notify({ icon:'<i class="fa fa-check"></i> ', title:'<strong>EXITO!</strong><br>', message:mensaje }, { type:'success' });
    }

    function error_message(mensaje){
        $.notify({ icon:'<i class="fa fa-exclamation-circle"></i> ', title:'<strong>ERROR!</strong><br>', message:mensaje }, { type:'danger' });
    }

    function passVerifica() {
        var passwordNew = $('#password_new').val();
        var passwordRep = $('#password_rep').val();

        if (passwordRep !== '' && passwordNew !== passwordRep) {
            $('#btnPassword').prop('disabled', true);
        } else {
            $('#btnPassword').prop('disabled', false);
        }
    }
</script>
@yield('js')
</body>
</html>
