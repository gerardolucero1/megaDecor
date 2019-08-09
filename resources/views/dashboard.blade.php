@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
    <div class="row">

    <div class="col-md-4">
    </div>

    <div class="col-md-4">
    <button type="button" class="btn btn-primary btn-block">Nuevo Cliente</button>
    </div>

    <div class="col-md-4">
    <button type="button" class="btn btn-primary btn-block">Nuevo Presupuesto</button>
    </div>

    </div>
    <br>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="block">
                    <div class="block-content">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-left mt-10 d-none d-sm-block">
                                <i class="si si-bag fa-3x text-body-bg-dark"></i>
                            </div>
                        <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="1500">1500</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Presupuestos</div>
                                 </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                <div class="block">
                    <div class="block-content">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-left mt-10 d-none d-sm-block">
                                <i class="si si-bag fa-3x text-body-bg-dark"></i>
                            </div>
                        <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="1500">1500</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Eventos hoy</div>
                                 </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                <div class="block">
                    <div class="block-content">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-left mt-10 d-none d-sm-block">
                                <i class="si si-bag fa-3x text-body-bg-dark"></i>
                            </div>
                        <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="1500">1500</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Prospectos</div>
                                     </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        

                        <div class="row">
                    <div class="col-md-4">                    
                
                        <button type="button" class="btn btn-primary btn-block">Nueva tarea</button>
                        
                        <div class="btn-group-vertical btn-block">

                        <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#myModal">
                            Elemento del dia 1
                        </button>
                        <!-- The Modal -->
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                            <div class="modal-content">                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <h4 class="modal-title">
                                <p>Fecha
                                </p>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <h4>Llamada de:</h4>
                                    <h4>Vendedor:</h4>
                                    <h4>Detalles:</h4>
                                </div>                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>                                
                            </div>
                            </div>
                        </div>
                      

                     
                        <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#myModal">
                            Elemento del dia 2
                        </button>
                        <!-- The Modal -->
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                            <div class="modal-content">                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <h4 class="modal-title">
                                <p>
                                </p>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <h4>Llamada de:</h4>
                                    <h4>Vendedor:</h4>
                                    <h4>Detalles:</h4>
                                </div>                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>                                
                            </div>
                            </div>
                        </div>
                        

                  
                        <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#myModal">
                            Elemento del dia 3
                        </button>
                        <!-- The Modal -->
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                            <div class="modal-content">                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <h4 class="modal-title">
                                <p>
                                </p>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <h4>Llamada de:</h4>
                                    <h4>Vendedor:</h4>
                                    <h4>Detalles:</h4>
                                </div>                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>                                
                            </div>
                            </div>
                        </div>
                     

                    
                        <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#myModal">
                            Elemento del dia 4
                        </button>
                        <!-- The Modal -->
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                            <div class="modal-content">                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <h4 class="modal-title">
                                <p>
                                </p>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <h4>Llamada de:</h4>
                                    <h4>Vendedor:</h4>
                                    <h4>Detalles:</h4>
                                </div>                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>                                
                            </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#myModal">
                            Elemento del dia 5
                        </button>
                        <!-- The Modal -->
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                            <div class="modal-content">                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <h4 class="modal-title">
                                <p>
                                </p>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <h4>Llamada de:</h4>
                                    <h4>Vendedor:</h4>
                                    <h4>Detalles:</h4>
                                </div>                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>                                
                            </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#myModal">
                            Elemento del dia 6
                        </button>
                        <!-- The Modal -->
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                            <div class="modal-content">                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <h4 class="modal-title">
                                <p>
                                </p>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <h4>Llamada de:</h4>
                                    <h4>Vendedor:</h4>
                                    <h4>Detalles:</h4>
                                </div>                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>                                
                            </div>
                            </div>
                        </div>
                  

                    </div>
                    </div>









                        <div class="row">
            @if (count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                <li>{{$error}}</li>    
                    @endforeach
                </ul>
            </div> 
            @endif

            @if (\Session::has('success'))
            <div class="alert alert-success">
            <p>{{\Session::get('success')}}</p>
            </div>                
            @endif

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">                        
                    <div class="panel-heading" style="background: #2e6da4 ; color: white;">
                            Full calendar
                    </div>
                    
                </div>
                <div class="panel-body">
                        {!! $calendar->calendar()!!}
                        {!! $calendar->script()!!}
                        <div id='calendar'></div>
                </div>
            </div>
            </div>

           
   
       
          
    <!-- END Page Content -->
@endsection
