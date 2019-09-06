@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        
            <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                <div class="col-12" style="padding-bottom:20px">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoPresupuestoModal">
                                <i class="fa fa-calendar-plus-o"></i> <i>Crear Presupuesto</i> 
                            </button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoClienteModal">
                                    <i class="fa fa-user-plus"></i> <i>Nuevo Cliente</i> 
                            </button>
                            <a class="btn btn-primary" href="http://localhost:8000/reporte_ventas_Agosto2019.xlsx">
                                    <i class="si si-cloud-download"></i> <i>Reporte de ventas</i> 
                            </a>
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#settingsMaster">
                                    <i class="si si-settings"></i> <i>Configuraciones</i> 
                            </button>
                </div>
                    <div class="col-6 col-lg-4  col-xl-4">
                        <a href="{{ route('presupuestos') }}" class="block block-link-shadow text-right" href="javascript:void(0)">
                            <div class="block-content block-content-full clearfix">
                                <div class="float-left mt-10 d-none d-sm-block">
                                    <i style="font-size: 40px" class="fa fa-clipboard"></i>
                                </div>
                            <div class="font-size-h3 font-w600 js-count-to-enabled">{{ count($numeroPresupuestos)}}</div>
                                <div class="font-size-sm font-w600 text-uppercase text-muted">Presupuestos Abiertos</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-4  col-xl-4">
                        <a href="{{ route('presupuestos-hoy') }}" class="block block-link-shadow text-right" href="javascript:void(0)">
                            <div class="block-content block-content-full clearfix">
                                <div class="float-left mt-10 d-none d-sm-block">
                                        <i style="font-size: 40px" class="fa fa-calendar"></i>
                                </div>
                            <div class="font-size-h3 font-w600"><span>{{ count($numeroPresupuestosDiaActual) }}</span></div>
                                <div class="font-size-sm font-w600 text-uppercase text-muted">EVentos el Día de Hoy</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-4  col-xl-4">
                        <a  class="block block-link-shadow text-right" href="javascript:void(0)">
                            <div class="block-content block-content-full clearfix">
                                <div class="float-left mt-10 d-none d-sm-block">
                                    <i class="si si-envelope-open fa-3x text-body-bg-dark"></i>
                                </div>
                                <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="15">15</div>
                                <div class="font-size-sm font-w600 text-uppercase text-muted">Seguimiento de prospectos</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-4  col-xl-4">
                        <a  class="block block-link-shadow text-right" href="javascript:void(0)">
                            <div class="block-content block-content-full clearfix">
                                <div class="float-left mt-10 d-none d-sm-block">
                                    <i class="si si-star fa-3x text-body-bg-dark"></i>
                                </div>
                                <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="15">Empleado del mes</div>
                                <div class="font-size-sm font-w600 text-uppercase text-muted">
                                    @if(!is_null($ArrayEmpleadoDelMes))
                                    {{ $ArrayEmpleadoDelMes->name }}@else sin empleado del mes
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-4  col-xl-4">
                        <a  class="block block-link-shadow text-right" href="javascript:void(0)">
                            <div class="block-content block-content-full clearfix">
                                <div class="float-left mt-10 d-none d-sm-block">
                                    <i class="fa fa-dollar fa-3x text-body-bg-dark"></i>
                                </div>
                            <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="15">0</div>
                                <div class="font-size-sm font-w600 text-uppercase text-muted">Creditos Atrasados</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-4  col-xl-4"></div>
                    <div class="col-6 col-lg-4  col-xl-4">
                            <a  class="block block-link-shadow text-right" href="javascript:void(0)">
                                <div class="block-content block-content-full clearfix">
                                    <div class="float-left mt-10 d-none d-sm-block">
                                        <i class="fa fa-dollar fa-3x text-body-bg-dark"></i>
                                    </div>
                                <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" ><span style="font-size: 10px; color:gray">Año Actual / Año Pasado</span><br>{{ count($presupuestosAnoActual) }} / {{ count($presupuestosAnoPasado) }}</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted"><span @if( $presupuestosAnoActual >= $presupuestosAnoPasado)
                                            style="color:green"
                                            @else
                                            style="color:orange"
                                            @endif>{{ round($porcentajeActual , 1) }}% / 100%</span><br>Meta ventas Mensual</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-lg-4  col-xl-4">
                                <a  class="block block-link-shadow text-right" href="javascript:void(0)">
                                    <div class="block-content block-content-full clearfix">
                                        <div class="float-left mt-10 d-none d-sm-block">
                                            <i class="fa fa-dollar fa-3x text-body-bg-dark"></i>
                                        </div>
                                    <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" ><span style="font-size: 10px; color:gray">Año Actual / Año Pasado</span><br>${{ $ventasAnoActual }} / ${{ $ventasAnoPasado }}</div>
                                        <div class="font-size-sm font-w600 text-uppercase text-muted"><span @if( $ventasAnoActual >= $ventasAnoPasado)
                                                style="color:green"
                                                @else
                                                style="color:orange"
                                                @endif>{{ round($porcentajeActualDinero , 1) }}% / 100%</span><br>Meta Ingresos Mensual</div>
                                    </div>
                                </a>
                            </div>
                            
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <task-list-component ></task-list-component>
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
                    <div class="col-md-12">
                        <div class="block">
                            <div class="block-content block-content-full">
                        <div id='calendar'></div>
                            </div>
                        </div>
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
