@extends('layouts.backend')

@section('content')
    @php
        
        $usuario = Auth::user()->id; 
        
        $permisos = App\Permission::where('user_id', $usuario)->first();   
    @endphp

   
        <!-- Page Content -->
        <div class="content">
            
        
            
                <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                    
                    <div class="col-10" style="padding-bottom:20px">
                            @if($permisos->dashboardCrearPresupuesto==1)
                            <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoPresupuestoModal">
                                    <i class="fa fa-calendar-plus-o"></i> <i>Crear presupuesto</i> 
                                </button>
                            @endif
                            @if($permisos->dashboardNuevoCliente==1)
                                <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoClienteModal">
                                        <i class="fa fa-user-plus"></i> <i>Nuevo cliente</i> 
                                </button>
                            @endif
                            @if($permisos->dashboardReporteVentas==1)
                                <a class="btn btn-primary" target="_blank" href="{{ route('pdf.ventas') }}">
                                        <i class="si si-cloud-download"></i> <i>Reporte de ventas</i> 
                                </a>
                            @endif
                            @if($permisos->dashboardConfiguraciones==1)
                                <button class="btn btn-secondary" data-toggle="modal" data-target="#settingsMaster">
                                        <i class="si si-settings"></i> <i>Configuraciones</i> 
                                </button>
                            @endif
                    </div>
                    
                    @if($permisos->dashboardAperturaCaja==1)
                    <div class="col-2">
                        @php
                            $registro = App\CashRegister::orderBy('id', 'DESC')->first();
                        @endphp
                        @if ($registro->estatus)
                            <a href="{{ route('caja.index') }}" class="btn btn-info">Caja abierta</a>
                            
                        @else
                            <a href="{{ route('caja.index') }}" class="btn btn-info">Apertura de caja</a>
                        @endif
                    </div>
                    @endif
                    
                    @if($permisos->dashboardPresupuestosActivos==1)
                    <div class="col-6 col-xl-3">
                            <a class="block block-link-pop text-right bg-primary" href="{{ route('presupuestos') }}">
                                <div class="block-content block-content-full clearfix border-black-op-b border-3x">
                                    <div class="float-left mt-10 d-none d-sm-block">
                                        <i class="si si-bar-chart fa-3x text-primary-light"></i>
                                    </div>
                                    <div class="font-size-h3 font-w600 text-white js-count-to-enabled" data-toggle="countTo" data-speed="1" data-to="{{ count($numeroPresupuestos) }}">{{ count($numeroPresupuestos) }}-{{ count($numeroPresupuestosF) }}</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-white-op">Presupuestos Activos</div>
                                </div>
                            </a>
                        </div>
                     @endif

                     @if($permisos->dashboardContratosHoy==1)
                        <div class="col-6 col-xl-3">
                                <a class="block block-link-pop text-right bg-earth" href="{{ route('presupuestos-hoy') }}">
                                    <div class="block-content block-content-full clearfix border-black-op-b border-3x">
                                        <div class="float-left mt-10 d-none d-sm-block">
                                            <i class="si si-trophy fa-3x text-earth-light"></i>
                                        </div>
                                        <div class="font-size-h3 font-w600 text-white"><span data-toggle="countTo" data-speed="1" data-to="{{ count($numeroPresupuestosDiaActual) }}" class="js-count-to-enabled">{{ count($numeroPresupuestosDiaActual) }}</span></div>
                                        <div class="font-size-sm font-w600 text-uppercase text-white-op">CONTRATOS DE HOY</div>
                                    </div>
                                </a>
                            </div>
                            @endif

                            @if($permisos->dashboardElementosDanados==1)
                        <div class="col-6 col-xl-3">
                            <a class="block block-link-pop text-right bg-corporate" href="{{ route('danados.aprobar') }}">
                                        <div class="block-content block-content-full clearfix border-black-op-b border-3x">
                                            <div class="float-left mt-10 d-none d-sm-block">
                                                <i class="si si-fire fa-3x text-corporate-light"></i>
                                            </div>
                                            @php
                                                $reportes = App\Missing::orderBy('id', 'DESC')->where('reportado', true)->where('aprobado', false)->get();
                                            @endphp
                                            <div class="font-size-h3 font-w600 text-white js-count-to-enabled" data-toggle="countTo" data-speed="" data-to="0">{{ count($reportes) }}</div>
                                            <div class="font-size-sm font-w600 text-uppercase text-white-op">ELEMENTOS DAÑADOS</div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                            @if($permisos->dashboardCreditosAtrasados==1)
                        <div class="col-6 col-xl-3">
                                    <a class="block block-link-pop text-right bg-elegance" href="{{ route('creditosAtrasados') }}">
                                            <div class="block-content block-content-full clearfix border-black-op-b border-3x">
                                                <div class="float-left mt-10 d-none d-sm-block">
                                                    <i class="si si-envelope-letter fa-3x text-elegance-light"></i>
                                                </div>
                                                @php
                                                    $date = Carbon\Carbon::now();
                                                    $fechaActual = $date->format('Y-m-d');
                                                    $contador = 0;

                                                    $creditos = App\Budget::orderBy('id', 'DESC')->where('pagado', null)->get();
                                                    foreach ($creditos as $credito) {
                                                        $cliente = App\Client::findOrFail($credito->client_id);
                                                        if($cliente->tipoPersona == 'FISICA'){
                                                            $persona = App\PhysicalPerson::where('client_id', $cliente->id)->first();
                                                            $fechaEvento = strtotime($credito->fechaEvento . '+' . $persona->diasCredito . '  days');
                                                            $fechaFormato = date('Y-m-d',$fechaEvento);
                                                            
                                                            if($fechaFormato < $fechaActual){
                                                                $contador++;
                                                            }
                                                            
                                                        }else{
                                                            $persona = App\MoralPerson::where('client_id', $cliente->id)->first();
                                                            $fechaEvento = strtotime($credito->fechaEvento . '+' . $persona->diasCredito . '  days');
                                                            $fechaFormato = date('Y-m-d',$fechaEvento);
                                                            
                                                            if($fechaFormato < $fechaActual){
                                                                $contador++;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <div class="font-size-h3 font-w600 text-white js-count-to-enabled" data-toggle="countTo" data-speed="" data-to="0">{{ $contador }}</div>
                                                <div class="font-size-sm font-w600 text-uppercase text-white-op">Créditos Atrasados</div>
                                            </div>
                                        </a>
                                    </div>
                            @endif
                                @php
                                $carbon = new \Carbon\Carbon();

                                $date = $carbon->now();
                                $datePasado = $carbon->now()->subYear();

                                $fechaHoy = $date->format('Y-m-d');
                                $fechaPasado = $datePasado->format('Y-m-d');

                                $fechaComoEntero = strtotime($fechaHoy);
                                $fechaComoEnteroPasado = strtotime($fechaPasado);
                                $anio = date("Y", $fechaComoEntero);
                                $anioPasado = date("Y", $fechaComoEnteroPasado);
                                

                                $start = new \Carbon\Carbon('first day of this month'); 
                                $end = new \Carbon\Carbon('last day of this month');
                                $fechaInicio = $start->format('Y-m-d');
                                $fechaFin = $end->format('Y-m-d');
                                $ingresoActual = 0;

                                $contratos = App\Budget::whereBetween('fechaEvento', array($fechaInicio, $fechaFin))->where('tipo', 'CONTRATO')->get();

                                foreach($contratos as $contrato){
                                    if($contrato->opcionIVA){
                                        $ingresoActual = $ingresoActual + ($contrato->total * 1.16);
                                    }else{
                                        $ingresoActual = $ingresoActual + $contrato->total;
                                    }
                                }

                                setlocale(LC_ALL, 'es_ES');
                                $date->format("F"); // Inglés.
                                $mes = $date->formatLocalized('%B');// mes en idioma español
                                @endphp

@if($permisos->dashboardComponenteVentas==1)
                                <div class="col-md-6">
                                        <a class="block" href="javascript:void(0)">
                                            <div class="block-content block-content-full">
                                                <div class="text-right">
                                                    <i class="si si-wallet fa-2x text-body-bg-dark"></i>
                                                </div>
                                                <div class="row pt-10 pb-30 text-center">
                                                    <div class="col-6 border-r">
                                                        <div class="font-size-h3 font-w600">{{ count($presupuestosAnoActual) }}</div>
                                                        <div class="font-size-sm font-w600 text-uppercase text-muted">
                                                                <span @if( $presupuestosAnoActual >= $presupuestosAnoPasado)
                                                                        style="color:green"
                                                                        @else
                                                                        style="color:orange"
                                                                        @endif>{{ round($porcentajeActual , 1) }}%</span><br>
                                                                Ventas {{ $mes }} {{ $anio }}</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="font-size-h3 font-w600">{{ count($presupuestosAnoPasado) }}</div>
                                                    <div class="font-size-sm font-w600 text-uppercase text-muted"><br>Ventas {{ $mes }} {{ $anioPasado }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-md-6">
                                        
                                            <a class="block" href="javascript:void(0)">
                                                <div class="block-content block-content-full">
                                                    <div class="text-right">
                                                        <i class="si si-wallet fa-2x text-body-bg-dark"></i>
                                                    </div>
                                                    <div class="row pt-10 pb-30 text-center">
                                                        <div class="col-6 border-r">
                                                            <div class="font-size-h3 font-w600">${{ number_format($ingresoActual,2) }} <span @if( $ingresoActual > $ventasAnoPasado)
                                                                    style="color:green"
                                                                    @else
                                                                    style="color:orange"
                                                                    @endif><span style="font-size:14px">{{ round($porcentajeActualDinero , 1) }}%<span></div>
                                                                    <div class="font-size-sm font-w600 text-uppercase text-muted">${{number_format($diferenciaDinero,2)}}</span><br>Ingresos {{ $mes }} {{ $anio }}</div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="font-size-h3 font-w600">${{ number_format($ventasAnoPasado,2) }} </div>
                                                        <div class="font-size-sm font-w600 text-uppercase text-muted"><br>Ingresos {{ $mes }} {{ $anioPasado }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        @endif
                                        @php
                                $usuario = Auth::user()->id;    
                            @endphp
                        
                        @if($permisos->dashboardComponenteContabilidad==1)
                                <contabilidad-component></contabilidad-component>        
                        @endif
                    </div>

                    <div class="row">
                            @if($permisos->dashboardListaTareas==1)
                        <div class="col-md-4">
                            <task-list-component ></task-list-component>
                        </div>
                        @endif


                        @if($permisos->dashboardCalendario==1)
                        <div class="col-md-8">
                                <div class="block">
                                    <div class="block-content block-content-full" style="position: relative">
                                            @if ($usuario != 2 && $usuario != 6)
                                        <button onclick="calendarTodos()" class="btn btn-success">Todos</button>
                                        @endif
                                        <button onclick="soloTareas()" class="btn btn-success" style="background:#F2E06E">Tareas</button>

                                        <button onclick="soloContratos()" class="btn btn-info" style="background:#91DFEB">Contratos</button>
                                        @if ($usuario != 2 && $usuario != 6)
                                        <button onclick="soloPresupuestos()" class="btn btn-info" style="background:#ECABF9">Presupuestos</button>
                                        @endif

                                <div id='calendar' style="position:absolute; z-index:4;  @if ($usuario == 2 || $usuario==6) display:none; @endif background:white; padding:15px; margin-left:-20px; width:100%"></div>
                                <div id='calendar2' style="position:absolute; z-index:1; @if ($usuario == 2 || $usuario==6) display:none; @endif background:white; padding:15px; margin-left:-20px; width:100%"></div>
                                <div id='calendar3' style="position:absolute; z-index:2; background:white; @if ($usuario == 2 || $usuario==6) display:none; @endif padding:15px; margin-left:-20px; width:100%"></div>
                                <div id='calendar4' style="position:absolute; z-index:3; background:white; padding:15px; margin-left:-20px; width:100%"></div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($permisos->dashboardVentasMes==1)
                        <div class="col-md-6 col-xl-4">
                                <div class="block">
                                    <div class="block-content block-content-full text-center bg-gd-sea">
                                        
                                        <p onclick="addevent()" class="font-size-lg font-w600 text-white mb-0">
                                            Ventas del mes de
                                        </p>
                                        <p class="font-size-sm text-uppercase font-w600 text-white-op mb-0">
                                          Abril 2020
                                        </p>
                                    </div>
                                    <div class="block-content block-content-full">
                                        <table class="table table-borderless table-striped table-hover mb-0">
                                            <tbody>
                                                @php
                                                    $cont = 0;
                                                    
                                                @endphp
                                                @foreach($ElementosVendedores as $ElementoVendedor)
                                                @php
                                                    $cont++;
                                                @endphp
                                                <tr>
                                                <td>{{$cont}}</td>
                                                    <td>
                                                        <strong>{{$ElementoVendedor->name}}</strong>
                                                    </td>
                                                    <td class="text-center" style="width: 40px;">
                                                        <strong class="text-success">{{$ElementoVendedor->ventas}}</strong>
                                                    </td>
                                                    <td><strong class="text-success">${{$ElementoVendedor->cantidadVenta}}</strong></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="block-content block-content-full text-center bg-body-light">
                                    <a class="btn btn-alt-secondary" href="{{ route('comisiones') }}">
                                            <i class="fa fa-eye mr-5"></i> Ver Comisiones
                                        </a>
                                    </div>
                                </div>
                            </div>
                          @endif

                          @if($permisos->dashboardVendedorMes==1)
                            <div class="col-6 col-lg-4  col-xl-4">
                                    <a  class="block block-link-shadow text-right" href="javascript:void(0)">
                                        <div class="block-content block-content-full clearfix">
                                            <div class="float-left mt-10 d-none d-sm-block">
                                                <i style="color:#ECE025" class="fa fa-star fa-3x "></i>
                                            </div>
                                            <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="15">Empleado del mes</div>
                                            <div class="font-size-sm font-w600 text-uppercase text-muted">
                                                @if(!is_null($ArrayEmpleadoDelMes))
                                                    {{ $ArrayEmpleadoDelMes->name }}@else sin empleado del mes
                                                    @endif</div>
                                        </div>
                                    </a>
                                </div>
                                @endif
                        
                    </div>
                    
        </div>

        <!-- END Page Content -->
        @include('../modals/settingsMaster')
        @include('../modals/nuevoPresupuestoModal')
        @include('../modals/categoriaEventoModal')
        @include('../modals/nuevoProductoModal')
        @include('../modals/nuevoClienteModal')
        @include('../modals/nuevaTareaModal')
        @include('../modals/categoriaTareaModal')
        @include('../modals/tiposEmpresaModal')
        @include('../modals/comoSupoModal')
   
    
@endsection
@section('scripts')

   <script>
      
   function soloTareas(){
       document.getElementById('calendar').style.zIndex="1";
       document.getElementById('calendar2').style.zIndex="2";
       document.getElementById('calendar3').style.zIndex="1";
       document.getElementById('calendar4').style.zIndex="1";
   }
   function calendarTodos(){
    document.getElementById('calendar').style.zIndex="2";
       document.getElementById('calendar2').style.zIndex="1";
       document.getElementById('calendar3').style.zIndex="1";
       document.getElementById('calendar4').style.zIndex="1";
   }
   function soloPresupuestos(){
    document.getElementById('calendar').style.zIndex="1";
       document.getElementById('calendar2').style.zIndex="1";
       document.getElementById('calendar3').style.zIndex="2";
       document.getElementById('calendar4').style.zIndex="1";
   }
   function soloContratos(){
    document.getElementById('calendar').style.zIndex="1";
       document.getElementById('calendar2').style.zIndex="1";
       document.getElementById('calendar3').style.zIndex="1";
       document.getElementById('calendar4').style.zIndex="2";
   }

   </script>
@endsection
