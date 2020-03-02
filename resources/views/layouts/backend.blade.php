<!doctype html>
<html lang="{{ config('app.locale') }}" class="no-focus">
    <head>
            @php
            $usuario = Auth::user()->id; 
            $permisos = App\Permission::where('user_id', $usuario)->first();   
        @endphp
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Mega Mundo Decor</title>

        <meta name="description" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="user" content="{{ Auth::user() }}">

        <!-- Icons -->
        <link rel="shortcut icon" href="http://megamundodecor.com/favicon.ico">
        <link rel="icon" sizes="192x192" type="image/png" href="http://megamundodecor.com/favicon.ico">
        <link rel="apple-touch-icon" sizes="180x180" href="http://megamundodecor.com/favicon.ico">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>

     

        <!-- Fonts and Styles -->
        @yield('css_before')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="{{ mix('/css/codebase.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
        
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">


        <!--
        <link rel="stylesheet" href="https://demo.pixelcave.com/codebase/assets/js/plugins/datatables/dataTables.bootstrap4.css">
        -->
        <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/corporate.css') }}"> -->
        @yield('styles')

        <!-- Scripts -->
        <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
    </head>
    <body onload="fechaActual()">

        @if(Auth::user()->archivado==1)
        <p style="font-size: 30px; text-align: center; color: red; margin-top: 100px;">Esta cuenta se encuentra suspendida</p>
        <a href="{{ route('logout') }}"><p style="width: 100%; text-align: center">Volver a Login</p></a>
        @if(Auth::user()->id==17)
            <a class="btn btn-info" style="width: 20%; margin-left: 40%" href="{{route('usuario.archivar', 17)}}">Reactivar cuenta</a>
            <p style="font-size: 10px; font-style: italic; text-align: center">Solo como webmaster puedes reactivar tu cuenta desde esta pantalla, por lo que este boton solo sera visible para tí</p>
        @endif
        @else
        <!-- Page Container -->
        <!--
            Available classes for #page-container:

        GENERIC

            'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Template._uiHandleTheme())

        SIDEBAR & SIDE OVERLAY

            'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
            'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
            'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
            'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
            'sidebar-inverse'                           Dark themed sidebar

            'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
            'side-overlay-o'                            Visible Side Overlay by default

            'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

            'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

        HEADER

            ''                                          Static Header if no class is added
            'page-header-fixed'                         Fixed Header

        HEADER STYLE

            ''                                          Classic Header style if no class is added
            'page-header-modern'                        Modern Header style
            'page-header-inverse'                       Dark themed Header (works only with classic Header style)
            'page-header-glass'                         Light themed Header with transparency by default
                                                        (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
            'page-header-glass page-header-inverse'     Dark themed Header with transparency by default
                                                        (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

        MAIN CONTENT LAYOUT

            ''                                          Full width Main Content if no class is added
            'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
            'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
        -->
        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-boxed">
            <!-- Side Overlay-->
            <aside id="side-overlay">
                <!-- Side Header -->
                <div class="content-header content-header-fullrow">
                    <div class="content-header-section align-parent">
                        <!-- Close Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary align-v-r" data-toggle="layout" data-action="side_overlay_close">
                            <i class="fa fa-times text-danger"></i>
                        </button>
                        <!-- END Close Side Overlay -->

                        <!-- User Info -->
                        <div class="content-header-item">
                            <a class="img-link mr-5" href="javascript:void(0)">
                                <img class="img-avatar img-avatar32" src="{{ asset('media/avatars/avatar15.jpg') }}" alt="">
                            </a>
                            <a class="align-middle link-effect text-primary-dark font-w600" href="javascript:void(0)">John Smith</a>
                        </div>
                        <!-- END User Info -->
                    </div>
                </div>
                <!-- END Side Header -->

                <!-- Side Content -->
                <div class="content-side">
                    <p>
                        Content..
                    </p>
                </div>
                <!-- END Side Content -->
            </aside>
            <!-- END Side Overlay -->

            <!-- Sidebar -->
            <!--
                Helper classes

                Adding .sidebar-mini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
                Adding .sidebar-mini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
                    If you would like to disable the transition, just add the .sidebar-mini-notrans along with one of the previous 2 classes

                Adding .sidebar-mini-hidden to an element will hide it when the sidebar is in mini mode
                Adding .sidebar-mini-visible to an element will show it only when the sidebar is in mini mode
                    - use .sidebar-mini-visible-b if you would like to be a block when visible (display: block)
            -->
            <nav id="sidebar">
                <!-- Sidebar Content -->
                <div class="sidebar-content">
                    <!-- Side Header -->
                    <div class="content-header content-header-fullrow px-15">
                        <!-- Mini Mode -->
                        <div class="content-header-section  sidebar-mini-visible-b">
                            <!-- Logo -->
                            <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                                <span class="text-dual-primary-dark">m</span><span class="text-primary">m</span>
                            </span>
                            <!-- END Logo -->
                        </div>
                        <!-- END Mini Mode -->

                        <!-- Normal Mode -->
                        <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                            <!-- Close Sidebar, Visible only on mobile screens -->
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                                <i class="fa fa-times text-danger"></i>
                            </button>
                            <!-- END Close Sidebar -->

                            <!-- Logo -->
                            <div class="content-header-item">
                                <a class="link-effect font-w700" href="/dashboard">
                                    <img src="http://megamundodecor.com/images/mega-mundo-decor.png" alt="" style="width: 100%">
                                    <span class="font-size-xl text-dual-primary-dark">Mega</span><span class="font-size-xl text-primary">Mundo</span>
                                </a>
                            </div>
                            <!-- END Logo -->
                        </div>
                        <!-- END Normal Mode -->
                    </div>
                    <!-- END Side Header -->

                    <!-- Side User -->
                    <div class="content-side content-side-full content-side-user px-10 align-parent">
                        <!-- Visible only in mini mode -->
                        <div class="sidebar-mini-visible-b align-v animated fadeIn">
                            <img class="img-avatar img-avatar32" src="https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/user_male2-512.png" alt="">
                        </div>
                        <!-- END Visible only in mini mode -->

                        <!-- Visible only in normal mode -->
                        <div class="sidebar-mini-hidden-b text-center">
                            <a class="img-link" href="javascript:void(0)">
                                <img class="img-avatar" src="https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/user_male2-512.png" alt="">
                            </a>
                            <ul class="list-inline mt-10">
                                <li class="list-inline-item">
                                    <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase" href="javascript:void(0)">{{ Auth::user()->name }}</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="link-effect text-dual-primary-dark" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <i class="si si-logout"></i>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <!-- END Visible only in normal mode -->
                    </div>
                    <!-- END Side User -->

                    <!-- Side Navigation -->
                    <div class="content-side content-side-full">
                        <ul class="nav-main">
                            @php
                                $usuario = Auth::user()->id;    
                            @endphp


                                <li>
                                        @if($permisos->dashboard==1)
                                    <a class="{{ request()->is('dashboard') ? ' active' : '' }}" href="/dashboard">
                                        <i class="si si-cup"></i><span class="sidebar-mini-hide">Dashboard</span>
                                    </a>
                                   @endif
                                   @if($permisos->clientes==1)
                                    <a class="nav-menu" href="{{ route('clientes') }}"><i class="si si-users"></i><span class="sidebar-mini-hide">Clientes</span></a>
                                    @endif
                                    @if($permisos->contratos==1)
                                    <a class="nav-menu" href="{{ route('presupuestos2') }}"><i class="si si-doc"></i><span class="sidebar-mini-hide">Contratos</span></a>
                                    @endif
                                    @if($permisos->presupuestos==1)
                                    <a class="nav-menu" href="{{ route('presupuestos') }}"><i class="fa fa-edit"></i><span class="sidebar-mini-hide">Presupuestos</span></a>
                                    @endif
                                    @if($permisos->comisiones==1)
                                    <a class="nav-menu" href="{{ route('comisiones') }}"><i class="fa fa-dollar"></i><span class="sidebar-mini-hide">Comisiones</span></a>
                                    @endif
                                    @if($permisos->ventas==1)
                                    <a class="nav-menu" href="{{ route('index.ventas') }}"><i class="si si-wallet"></i><span class="sidebar-mini-hide">Ventas</span></a>@endif
                                    <!--
                                    <a class="nav-menu" href="{{ route('inventario') }}"><i class="si si-wallet"></i><span class="sidebar-mini-hide">Inventario</span></a>
                                    -->
                                    @if($permisos->inventarioInventario==1)
                                    <a class="nav-menu" href="{{ route('inventario') }}"><i class="fa fa-list-ul"></i><span class="sidebar-mini-hide">Productos</span></a>
                                      @endif 
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-puzzle"></i><span class="sidebar-mini-hide">Inventario</span></a>
                                    <ul>
                                        @if($permisos->inventarioPaquetes==1)
                                        <li>
                                            <a href="{{ route('paquetes') }}">Paquetes</a>
                                        </li>
                                        @endif
                                        @if($permisos->inventarioProximos==1)
                                        <li>
                                            <a href="{{ route('proximos') }}">Proximos</a>
                                        </li>
                                        @endif
                                        @if($permisos->inventarioFamilias==1)
                                        <li>
                                            <a href="{{ route('familia.index') }}">Familias</a>
                                        </li>
                                        @endif
                                        @if($permisos->inventarioGrupos==1)
                                        <li>
                                            <a href="{{ route('grupo.index') }}">Grupos</a>
                                        </li>
                                        @endif
                                        
                                        <li>
                                            <a href="{{ route('inventario.danados') }}">Dañados</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('inventario2') }}">Hacer Inventario</a>
                                        </li>

                                    </ul>
                                    @if($permisos->Proveedores==1)
                                    <a class="nav-menu" href="{{ route('proveedores.index') }}"><i class="fa fa-user"></i><span class="sidebar-mini-hide">Proveedores</span></a>
                                    @endif
                                    @if($permisos->usuarios==1)
                                    <a class="nav-menu" href="{{ route('pantallaUsuarios') }}"><i class="fa fa-user"></i><span class="sidebar-mini-hide">Usuarios</span></a>
                                    @endif
                                </li>
                                <li class="">
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-dollar"></i><span class="sidebar-mini-hide">Contabilidad</span></a>
                                        <ul>
                                            <li>
                                                <a href="{{ route('contabilidad.historialCortes') }}">Historial cortes</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('facturas') }}">Facturas Solicitadas</a>
                                            </li>
                                        </ul>
                                    </li>
                                <li class="nav-main-heading">
                                    <span class="sidebar-mini-visible">PF</span><span class="sidebar-mini-hidden">Ayuda</span>
                                </li>
                                <li>
                                    <a href="/">
                                        <i class="si si-question"></i><span class="sidebar-mini-hide">Preguntas Frecuentes</span>
                                    </a>
                                </li>  
                       
                                                        
                        
                            
                        </ul>
                    </div>
                    <!-- END Side Navigation -->
                </div>
                <!-- Sidebar Content -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="content-header-section">
                            <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                                    <i class="fa fa-navicon"></i>
                                </button>
                    </div>
                    <div class="content-header-section">
                        <!-- User Dropdown -->
                        
                        <!-- END User Dropdown -->

                        <!-- Notifications -->
                        <!-- END Notifications -->

                        <!-- Toggle Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        
                        <p id="fechaActual" style="font-style: italic">Fecha Actual</p>
                        <script>
                            function fechaActual(){
                                var meses = new Array ("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
                                var f=new Date();
                                document.getElementById('fechaActual').innerHTML=f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
                            }
                        </script>
                        <!-- END Toggle Side Overlay -->
                    </div>
                    <!-- END Right Section -->
                </div>
                <!-- END Header Content -->

                <!-- Header Search -->
                <div id="page-header-search" class="overlay-header">
                    <div class="content-header content-header-fullrow">
                        <form action="/dashboard" method="POST">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <!-- Close Search Section -->
                                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                    <button type="button" class="btn btn-secondary" data-toggle="layout" data-action="header_search_off">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <!-- END Close Search Section -->
                                </div>
                                <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                   </div>
                </div>
                <!-- END Header Search -->

                <!-- Header Loader -->
                <!-- Please check out the Activity page under Elements category to see examples of showing/hiding it -->
                <div id="page-header-loader" class="overlay-header bg-primary">
                    <div class="content-header content-header-fullrow text-center">
                        <div class="content-header-item">
                            <i class="fa fa-sun-o fa-spin text-white"></i>
                        </div>
                    </div>
                </div>
                <!-- END Header Loader -->
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">
                <section id="app">
                    @yield('content')
                </section>
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="opacity-0">
                <div class="content py-20 font-size-xs clearfix">
                    <div class="float-right">
                        Desarrollado por <a class="font-w600" href="https:partnergrammer.com" target="_blank"><span><img src="media/photos/icon_parnergrammer.png" style="width: 17px; margin-top: -5px;" alt=""></span> Partnergrammer</a>
                    </div>
                    <div class="float-left">
                        <a class="font-w600" href="http://megamundodecor.com/servicios.aspx" target="_blank"><span style="color:black">Todos los derechos reservados</span> Mega Mundo Decor</a> &copy; <span class="js-year-copy"></span>
                    </div>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->
        
        
        
        
        <!-- Codebase Core JS -->
        <script src="{{ mix('js/codebase.app.js') }}"></script>
        
<script>  

$(document).ready( function () {

    $('#TablaClientes').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pageLength": 100,
        "language": {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }}
    });
    Codebase.layout('sidebar_mini_on');
    Codebase.layout('sidebar_style_inverse_on');
    
} ); 
$(document).ready( function () {
    $('#TablaClientesArchivados').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pageLength": 100,
        "language": {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }}
    });
} ); 
$(document).ready( function () {
    $('#TablaPresupuestosArchivados').DataTable({
        "order": [[ 1, "desc" ]],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "pageLength": 100,
        "language": {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }}
    });
} ); 
$(document).ready( function () {
    $('#TablaPresupuestos').DataTable({
        "order": [[ 1, "asc" ]],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pageLength": 100,
        "language": {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }}
    });
} ); 
$(document).ready( function () {
    $('#TablaCortes').DataTable({
        "order": [[ 0, "desc" ]],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pageLength": 50,
        "language": {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }}
    });
} ); 
$(document).ready( function () {
    $('#TablaPresupuestosHistorial').DataTable({
        "order": [[ 1, "desc" ]],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pageLength": 100,
        "language": {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }}
    });
} ); 



$(document).ready( function () {
    $('#TablaInventarioFisico').DataTable({
        "order": [[ 1, "desc" ]],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pageLength": 100,
        "language": {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }}
    });
} ); 

//tabla test inventario



</script>
        <!-- Laravel Scaffolding JS -->
        <script src="{{ mix('js/laravel.app.js') }}"></script>
       
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        
         <!--librerias tempobootstrap -->
         

        @yield('scripts')
        
        @endif
    </body>
</html>
