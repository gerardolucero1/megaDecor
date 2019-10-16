@extends('layouts.backend')

@section('content')
    @php
        $usuario = Auth::user()->id;    
    @endphp

    @if ($usuario != 2)
        <!-- Page Content -->
        <div class="content">
            
        
            
                <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                    <div class="col-10" style="padding-bottom:20px">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoPresupuestoModal">
                                    <i class="fa fa-calendar-plus-o"></i> <i>Crear presupuesto</i> 
                                </button>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoClienteModal">
                                        <i class="fa fa-user-plus"></i> <i>Nuevo cliente</i> 
                                </button>
                                <button class="btn btn-primary" data-toggle="modal" data-target="">
                                        <i class="fa fa-dollar"></i> <i>Nuevo Ingreso</i> 
                                </button>
                                <a class="btn btn-primary" target="_blank" href="{{ route('pdf.ventas') }}">
                                        <i class="si si-cloud-download"></i> <i>Reporte de ventas</i> 
                                </a>
                                <button class="btn btn-secondary" data-toggle="modal" data-target="#settingsMaster">
                                        <i class="si si-settings"></i> <i>Configuraciones</i> 
                                </button>
                    </div>
                    @if ($usuario == 17)
                    <div class="col-2">
                        <a style="" href="{{ route('caja.index') }}" class="btn btn-info">Apertura de caja</a> 
                    </div>
                    @endif
                    

                    <div class="col-6 col-xl-3">
                            <a class="block block-link-pop text-right bg-primary" href="{{ route('presupuestos') }}">
                                <div class="block-content block-content-full clearfix border-black-op-b border-3x">
                                    <div class="float-left mt-10 d-none d-sm-block">
                                        <i class="si si-bar-chart fa-3x text-primary-light"></i>
                                    </div>
                                    <div class="font-size-h3 font-w600 text-white js-count-to-enabled" data-toggle="countTo" data-speed="1" data-to="{{ count($numeroPresupuestos) }}">{{ count($numeroPresupuestos) }}</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-white-op">Presupuestos Activos</div>
                                </div>
                            </a>
                        </div>
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
                        <div class="col-6 col-xl-3">
                                    <a class="block block-link-pop text-right bg-corporate" href="javascript:void(0)">
                                        <div class="block-content block-content-full clearfix border-black-op-b border-3x">
                                            <div class="float-left mt-10 d-none d-sm-block">
                                                <i class="si si-fire fa-3x text-corporate-light"></i>
                                            </div>
                                            <div class="font-size-h3 font-w600 text-white js-count-to-enabled" data-toggle="countTo" data-speed="" data-to="0">0</div>
                                            <div class="font-size-sm font-w600 text-uppercase text-white-op">Prospectos DEL MES</div>
                                        </div>
                                    </a>
                                </div>
                        <div class="col-6 col-xl-3">
                                        <a class="block block-link-pop text-right bg-elegance" href="javascript:void(0)">
                                            <div class="block-content block-content-full clearfix border-black-op-b border-3x">
                                                <div class="float-left mt-10 d-none d-sm-block">
                                                    <i class="si si-envelope-letter fa-3x text-elegance-light"></i>
                                                </div>
                                                <div class="font-size-h3 font-w600 text-white js-count-to-enabled" data-toggle="countTo" data-speed="" data-to="0">0</div>
                                                <div class="font-size-sm font-w600 text-uppercase text-white-op">Créditos Atrasados</div>
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
                                                        <div class="font-size-h3 font-w600">{{ count($presupuestosAnoActual) }}</div>
                                                        <div class="font-size-sm font-w600 text-uppercase text-muted">
                                                                <span @if( $presupuestosAnoActual >= $presupuestosAnoPasado)
                                                                        style="color:green"
                                                                        @else
                                                                        style="color:orange"
                                                                        @endif>{{ round($porcentajeActual , 1) }}%</span><br>
                                                            Ventas Octubre 2019</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="font-size-h3 font-w600">{{ count($presupuestosAnoPasado) }}</div>
                                                        <div class="font-size-sm font-w600 text-uppercase text-muted"><br>Ventas Octubre 2018</div>
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
                                                            <div class="font-size-h3 font-w600">${{ $ventasAnoActual }} <span @if( $ventasAnoActual > $ventasAnoPasado)
                                                                    style="color:green"
                                                                    @else
                                                                    style="color:orange"
                                                                    @endif><span style="font-size:14px">{{ round($porcentajeActualDinero , 1) }}%<span></div>
                                                            <div class="font-size-sm font-w600 text-uppercase text-muted">${{$diferenciaDinero}}</span><br>Ingresos Octubre 2019</div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="font-size-h3 font-w600">${{ $ventasAnoPasado }} </div>
                                                            <div class="font-size-sm font-w600 text-uppercase text-muted"><br>Ingresos Octubre 2018</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        @php
                                $usuario = Auth::user()->id;    
                            @endphp
                            @if ($usuario == 17)
                                            
                                        <div class="col-md-6">
                                                <a class="block" href="javascript:void(0)">
                                                    <div class="block-content block-content-full">
                                                        <div class="text-right">
                                                            <i class="si si-wallet fa-2x text-body-bg-dark"></i>
                                                        </div>
                                                        <label for="" style="font-size:10px; color:red; font-style: italic">Elementos test, disponible a partir del 16 Octubre 2019</label>
                                                        <div class="row pt-10 pb-30 text-center">
                                                            <div class="col-6 border-r">
                                                                
                                                                <div class="font-size-h3 font-w600">$1,550.00<span><br><span style="font-size:14px; line-height: 10px;">Egresos: $238.00<span></div>
                                                                <div class="font-size-sm font-w600 text-uppercase text-muted"></span><br>Ingresos del dia</div><br>
                                                                <button class="btn btn-sm btn-success" style="">Nuevo Ingreso</button> <button class="btn btn-sm btn-danger" style="">Nuevo Egreso</button>
                                                                
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="font-size-h3 font-w600">$1,322.00 </div>
                                                                <div class="font-size-sm font-w600 text-uppercase text-muted"><br>Total en caja</div>
                                                                <button class="btn btn-sm btn-success" style="">Corte de caja</button>
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
                                                            <label for="" style="font-size:10px; color:red; font-style: italic">Elementos test, disponible a partir del 16 Octubre 2019</label>
                                                            <div class="row pt-10 pb-30 text-left">
                                                                <div class="col-6  border-r">
                                                                    <p style="font-weight: bold;">Ingresos: </p>
                                                                    <ul style="font-size: 12px;">
                                                                        <li>Abono Contrato NM23 - $350.00</li>
                                                                        <li>Abono Contrato NM27 - $1,700.00</li>
                                                                        <li>Abono Contrato NM48 - $3,950.00</li>
                                                                    </ul>
                                                                  
                                                                    
                                                                </div>
                                                                <div class="col-6">
                                                                        <p style="font-weight: bold;">Ingresos: </p>
                                                                        <ul style="font-size: 12px;">
                                                                            <li>Pago Proveedor - $3,450.00</li>
                                                                            <li>Pago Proveedor - $700.00</li>
                                                                            <li style="font-style: italic">Gasolina - $200.00</li>
                                                                        </ul>
                                                                      
                                                                        
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                @endif
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <task-list-component ></task-list-component>
                        </div>

                        <div class="col-md-8">
                                <div class="block">
                                    <div class="block-content block-content-full" style="position: relative">
                                        <button onclick="calendarTodos()" class="btn btn-success">Todos</button>
                                        <button onclick="soloTareas()" class="btn btn-success" style="background:#F2E06E">Tareas</button>
                                        <button onclick="soloContratos()" class="btn btn-info" style="background:#91DFEB">Eventos</button>
                                        <button onclick="soloPresupuestos()" class="btn btn-info" style="background:#ECABF9">Presupuestos</button>
                                <div id='calendar' style="position:absolute; z-index:4; background:white; padding:15px; margin-left:-20px; width:100%"></div>
                                <div id='calendar2' style="position:absolute; z-index:3; background:white; padding:15px; margin-left:-20px; width:100%"></div>
                                <div id='calendar3' style="position:absolute; z-index:2; background:white; padding:15px; margin-left:-20px; width:100%"></div>
                                <div id='calendar4' style="position:absolute; z-index:1; background:white; padding:15px; margin-left:-20px; width:100%"></div>
                                    </div>
                                </div>
                            </div>

                        <div class="col-md-6 col-xl-4">
                                <div class="block">
                                    <div class="block-content block-content-full text-center bg-gd-sea">
                                        
                                        <p onclick="addevent()" class="font-size-lg font-w600 text-white mb-0">
                                            Ventas del mes de
                                        </p>
                                        <p class="font-size-sm text-uppercase font-w600 text-white-op mb-0">
                                            Septiembre 2019
                                        </p>
                                    </div>
                                    <div class="block-content block-content-full">
                                        <table class="table table-borderless table-striped table-hover mb-0">
                                            <tbody>
                                                @foreach($ElementosVendedores as $ElementoVendedor)
                                                <tr>
                                                    <td class="text-center" style="width: 40px;">01</td>
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
    @else
        <h1 class="text-center">BODEGA</h1>
    @endif
    
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
