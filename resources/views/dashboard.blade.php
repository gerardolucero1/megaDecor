@extends('layouts.backend')
@section('styles')
        <link rel="stylesheet" media="all" href="https://public-assets.envato-static.com/assets/market/core/index-ea981150062d8d0bb0eb8b55d331a9b35bf4b1c953d28e897045ddf63c9bebfe.css" />
        <link rel="stylesheet" media="all" href="https://public-assets.envato-static.com/assets/market/pages/preview/index-004d35cdd5d555cdd3e956d1b916825642de06529f0fe91fd9f390813761d2fc.css" />
        <link rel="stylesheet" media="all" href="https://cookiebot-assets.envato-static.com/cookiebot.css" />

        <link rel="apple-touch-icon-precomposed" type="image/x-icon" href="https://public-assets.envato-static.com/icons/themeforest.net/apple-touch-icon-72x72-precomposed.png" sizes="72x72" />
        <link rel="apple-touch-icon-precomposed" type="image/x-icon" href="https://public-assets.envato-static.com/icons/themeforest.net/apple-touch-icon-114x114-precomposed.png" sizes="114x114" />
        <link rel="apple-touch-icon-precomposed" type="image/x-icon" href="https://public-assets.envato-static.com/icons/themeforest.net/apple-touch-icon-144x144-precomposed.png" sizes="144x144" />
        <link rel="apple-touch-icon-precomposed" type="image/x-icon" href="https://public-assets.envato-static.com/icons/themeforest.net/apple-touch-icon-precomposed.png" />

        <script src="https://public-assets.envato-static.com/assets/market/pages/full_screen_preview/index-96b0ff9bb57e0a7c7b9207bc83b24b75539435928baaa36ec23261ef25632ba6.js"></script>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
       
@endsection
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
                    <div class="col-md-8">
                    
                        <div class="jumbotron mt-5">
                            <h1 style="text-align: center;">Aqui va el calendario</h1>
                            <p style="text-align: center;">El Imperio vijayanagara fue un imperio nacido en la meseta del Decán, en el centro-sur de la India, que en su momento de mayor esplendor llegó a poseer el tercio sur del subcontinente. En kannada se le conoce por ವಿಜಯನಗರ ಸಾಮ್ರಾಜ್ಯ (Vijayanagara Sāmrājya), y en telugú se le denomina విజయనగర సామ్రాజ్యము (Vijayanagara Sāmrājyam). Establecido en 1336 por Harihara I y su hermano Bukka Raya I, existió hasta 1646, si bien su decadencia comenzó tras una aplastante derrota militar contra los sultanatos del Decán en 1565 de la que nunca se recuperaría.

El Imperio recibe el nombre oficial que se le daba por entonces a su capital, Vijayanagara (en español: La Ciudad de la Victoria), cuyas ruinas, declaradas Patrimonio de la Humanidad por la Unesco, rodean la localidad hoy llamada Hampi en el estado de Karnataka. Las crónicas de los viajeros de la época como Duarte Barbosa, Niccolò Da Conti o Domingo Paes y Fernão Nunes, quienes, basándose en sus experiencias en la India dieron lugar a la Chronica dos Reis de Bisnaga; y los registros locales nos brindan información crucial sobre su historia. Las excavaciones arqueológicas revelan el poder y riqueza de este imperio.</p>
                        </div>
                  
                    </div>
                   
                 
             
                </div>
    <!-- END Page Content -->
@endsection
