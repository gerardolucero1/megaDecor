@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        
      
        
            <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                <div class="col-12" style="padding-bottom:20px">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoPresupuestoModal">
                                <i class="fa fa-calendar-plus-o"></i> <i>Crear presupuesto</i> 
                            </button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoClienteModal">
                                    <i class="fa fa-user-plus"></i> <i>Nuevo cliente</i> 
                            </button>
                            <a class="btn btn-primary" target="_blank" href="{{ route('pdf.ventas') }}">
                                    <i class="si si-cloud-download"></i> <i>Reporte de ventas</i> 
                            </a>
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#settingsMaster">
                                    <i class="si si-settings"></i> <i>Configuraciones</i> 
                            </button>
                </div>
                

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
                                                        Ventas Septiembre 2019</div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="font-size-h3 font-w600">{{ count($presupuestosAnoPasado) }}</div>
                                                    <div class="font-size-sm font-w600 text-uppercase text-muted"><br>Ventas Septiembre 2018</div>
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
                                                        <div class="font-size-sm font-w600 text-uppercase text-muted">${{$diferenciaDinero}}</span><br>Ingresos Septiembre 2019</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="font-size-h3 font-w600">${{ $ventasAnoPasado }} </div>
                                                        <div class="font-size-sm font-w600 text-uppercase text-muted"><br>Ingresos Septiembre 2018</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <task-list-component ></task-list-component>
                    </div>

                    <div class="col-md-8">
                            <div class="block">
                                <div class="block-content block-content-full">
                                    <button class="btn btn-info">Ver todo</button>
                                    <button onclick="SoloTareas()" class="btn btn-success">Tareas</button>
                                    <button class="btn btn-info">Eventos</button>
                            <div id='calendar'></div>
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
@endsection
@section('scripts')

   <script>
      
   

   </script>
@endsection
