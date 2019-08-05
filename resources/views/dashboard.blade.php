@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        
            <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                    <div class="col-6 col-lg-4  col-xl-4">
                        <a class="block block-link-shadow text-right" href="javascript:void(0)">
                            <div class="block-content block-content-full clearfix">
                                <div class="float-left mt-10 d-none d-sm-block">
                                    <i style="font-size: 40px" class="fa fa-clipboard"></i>
                                </div>
                                <div class="font-size-h3 font-w600 js-count-to-enabled">15</div>
                                <div class="font-size-sm font-w600 text-uppercase text-muted">Presupuestos Pendientes</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-4  col-xl-4">
                        <a class="block block-link-shadow text-right" href="javascript:void(0)">
                            <div class="block-content block-content-full clearfix">
                                <div class="float-left mt-10 d-none d-sm-block">
                                        <i style="font-size: 40px" class="fa fa-calendar"></i>
                                </div>
                                <div class="font-size-h3 font-w600"><span>780</span></div>
                                <div class="font-size-sm font-w600 text-uppercase text-muted">EVentos el Día de Hoy</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-4  col-xl-4">
                        <a class="block block-link-shadow text-right" href="javascript:void(0)">
                            <div class="block-content block-content-full clearfix">
                                <div class="float-left mt-10 d-none d-sm-block">
                                    <i class="si si-envelope-open fa-3x text-body-bg-dark"></i>
                                </div>
                                <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="15">15</div>
                                <div class="font-size-sm font-w600 text-uppercase text-muted">Seguimiento de prospectos</div>
                            </div>
                        </a>
                    </div>
                    
                </div>
                <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                        

                </div>
    </div>
    <!-- END Page Content -->
@endsection
