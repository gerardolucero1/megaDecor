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
                            <button class="btn btn-primary" data-toggle="modal" data-target="#reporteVentas">
                                    <i class="si si-cloud-download"></i> <i>Reporte de ventas</i> 
                            </button>
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
                    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <task-list-component ></task-list-component>
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
