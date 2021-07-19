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
        <link rel="shortcut icon" href="http://caledro.com/megamundo/favicon.ico">
        <link rel="icon" sizes="192x192" type="image/png" href="http://caledro.com/megamundo/favicon.ico">
        <link rel="apple-touch-icon" sizes="180x180" href="http://caledro.com/megamundo/favicon.ico">
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
       
        <div class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-boxed">
        
          
            
                <section id="app">
                    @yield('content')
                </section>
        
        
        </div>
        <!-- END Page Container -->
        
        
        
        
        <!-- Codebase Core JS -->
        <script src="{{ mix('js/codebase.app.js') }}"></script>
        

        <!-- Laravel Scaffolding JS -->
        <script src="{{ mix('js/laravel.app.js') }}"></script>
       
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        
         <!--librerias tempobootstrap -->
         

        @yield('scripts')
        
        @endif
    </body>
</html>
