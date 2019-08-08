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
        
        
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
       

        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
       
        
@endsection
@section('content')
    <!-- Page Content -->
<div class="col-sm-12">   
<div class="row mt-10">  
                <div class="col">
                <button type="button" class="btn btn-primary btn-block">Calendario</button>
                </div> 
                <div class="col">
                <button type="button" class="btn btn-primary btn-block">Nuevo Cliente</button>
                </div> 
                <div class="col">
                <button type="button" class="btn btn-primary btn-block">Nuevo Presupuesto</button>
                </div> 
                </div> 
            <br>
            <hr>  
     </div>
        
   

     <div class="row">  
 <div class="col-sm-12">
 
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Presupuestos<small>  PartnerGrammer</small></h3>
                </div>
                <div class="block-content block-content-full">
                        <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                            
                            <div class="row">
                                <div class="col-sm-12">
                                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="DataTables_Table_1" role="grid" aria-describedby="DataTables_Table_1_info">
                                            <thead>
                                                <tr role="row">
                                                <th class="text-center sorting_asc" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label=": activate to sort column descending">ID</th>
                                                <th class="text-center sorting_disabled" style="width: 15%;" rowspan="1" colspan="1" aria-label="Profile">cliente</th>
                                                <th class="text-center sorting_disabled" style="width: 15%;" rowspan="1" colspan="1" aria-label="Profile">contrato</th>                    
                                                <th class="text-center sorting_disabled" style="width: 15%;" rowspan="1" colspan="1" aria-label="Profile">fecha</th>
                                                <th class="text-center sorting_disabled" style="width: 15%;" rowspan="1" colspan="1" aria-label="Profile">vendedor</th>
                                                <th class="text-center sorting_disabled" style="width: 15%;" rowspan="1" colspan="1" aria-label="Profile">lugar</th>
                                                <th class="text-center sorting_disabled" style="width: 15%;" rowspan="1" colspan="1" aria-label="Profile">version</th>                    
                                                <th class="text-center sorting_disabled" style="width: 15%;" rowspan="1" colspan="1" aria-label="Profile">opciones</th>
                                                <th class="text-center sorting_disabled" style="width: 15%;" rowspan="1" colspan="1" aria-label="Profile">Acceso</th>
                                                <th class="text-center sorting_disabled" style="width: 15%;" rowspan="1" colspan="1" aria-label="Profile">Perfil</th>
                                                
                                                </tr>
                                            </thead>
                                            <tbody>      
                                            @foreach($users as $user)
                                            <tr role="row" class="odd">
                                                    <td class="text-center sorting_1">{{$user->id}}</td>
                                                    <td class="font-w600">{{$user->cliente}}</td>
                                                    <td class="d-none d-sm-table-cell">{{$user->contrato}}</td>                        
                                                    <td class="d-none d-sm-table-cell">{{$user->fecha}}</td>
                                                    <td class="d-none d-sm-table-cell">{{$user->vendedor}}</td>
                                                    <td class="d-none d-sm-table-cell">{{$user->lugar}}</td>
                                                    <td class="d-none d-sm-table-cell">{{$user->version}}</td>
                                                    <td class="d-none d-sm-table-cell">{{$user->opciones}}</td>                
                                                    <td class="d-none d-sm-table-cell">
                                                        <span class="badge badge-success">VIP</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="View Customer">
                                                            <i class="fa fa-user"></i>
                                                        </button>
                                                    </td>                                                
                                                </tr>
                                                @endforeach
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
                   <script>
                    $(document).ready(function() {
                        $('#users').DataTable();
                        } );
                    </script>
             
                </div>
    <!-- END Page Content -->
@endsection
