@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')

    <section class="container">

        <div class="row">
                    <div class="col-md-6"><a href="javascript:void(0)" class="block"><div class="block-content block-content-full"><div class="text-right"><i class="si si-wallet fa-2x text-body-bg-dark"></i></div> <div class="row pt-10 pb-30 text-center"><div class="col-6 border-r"><div class="font-size-h3 font-w600">4</div> <div class="font-size-sm font-w600 text-uppercase text-muted"><span style="color: green;">200%</span><br>
                        Ventas Septiembre 2019</div></div> <div class="col-6"><div class="font-size-h3 font-w600">2</div> <div class="font-size-sm font-w600 text-uppercase text-muted"><br>Ventas Septiembre 2018</div></div></div></div></a></div>

                        <div class="col-md-6"><a href="javascript:void(0)" class="block"><div class="block-content block-content-full"><div class="text-right"><i class="si si-wallet fa-2x text-body-bg-dark"></i></div> <div class="row pt-10 pb-30 text-center"><div class="col-6 border-r"><div class="font-size-h3 font-w600">$879 </div> <div class="font-size-sm font-w600 text-uppercase text-muted"><span style="color: orange;">90.2%</span><br>Ingresos Septiembre 2019</div></div> <div class="col-6"><div class="font-size-h3 font-w600">$974 </div> <div class="font-size-sm font-w600 text-uppercase text-muted"><br>Ingresos Septiembre 2018</div></div></div></div></a></div>
                        <div class="col-6 col-lg-4  col-xl-4">
                                <a  class="block block-link-shadow text-right" href="javascript:void(0)">
                                    <div class="block-content block-content-full clearfix">
                                        <div class="float-left mt-10 d-none d-sm-block">
                                            <i class="fa fa-star fa-3x text-body-bg-dark"></i>
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
    
        <div >
        <button class="btn btn-secondary" data-toggle="modal" data-target="#settingsMaster">
                <i class="si si-settings"></i> Configurar comisiones
             </button>
            </div>
            <div id="PresupuestosActivos" style="padding-top: 20px">
            
                <div class="block">
                    <div class="block-header block-header-default">
                        <div class="col-md-3">
                        <h3 class="block-title" style="color:green">Comisiones por vendedor</h3>
                    </div>
                    <div class="col-md-9 text-right">
                           
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoPresupuesto">
                                                <i class="si si-printer"></i> <i>Imprimir Reporte</i> 
                                            </button>
                                    <button onclick="presupuestosArchivados()" class="btn btn-secondary">
                                                <i class="fa fa-calendar-minus-o"></i> <i>Comisiones por evento</i> 
                                            </button>
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Vendedor</th>
                                    <th># Ventas</th>
                                    <th>Mes Actual</th>
                                    <th>Total Ventas</th>
                                    <th>Comisión</th>
                                    <th>Opciones</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>                    
                                 @php
                                    use Carbon\Carbon;
                                    setlocale(LC_ALL, 'es_ES');
                                    $date = Carbon::now();
                                    
                                    $fecha = Carbon::parse($date);
                                    $fecha->format("F"); // Inglés.
                                    $mes = $fecha->formatLocalized('%B');// mes en idioma español
                                 @endphp    
                                @foreach($CompleteUsers as $usuario)
                                <tr role="row" class="odd">
                                <td class="text-center sorting_1">{{ $usuario->name}}</td>
                                    <td class="">{{ $usuario->ventas}}</td>
                                    <td class="d-none d-sm-table-cell">{{ $mes }}</td>
                                    <td class="d-none d-sm-table-cell">${{ $usuario->totalventas}}</td>
                                    <td class="d-none d-sm-table-cell">$
                                        @php
                                         echo number_format((intval($usuario->totalventas))*50)
                                        @endphp
                                         </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="modal" data-target="#contratos{{ $usuario->id }}">
                                            <i class="fa fa-list-ul"></i>
                                        </button>

                                        <!-- Modal -->
                                    <div class="modal fade" id="contratos{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Contratos del usuario {{ $usuario->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Fecha Evento</th>
                                                                <th scope="col">Cliente</th>
                                                                <th scope="col">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $user = App\User::where('id', $usuario->id)->first();
                                                            @endphp
                                                            @foreach ($user->budgets as $budget)
                                                                <tr>
                                                                    <th scope="row">{{ $budget->id }}</th>
                                                                    <td>{{ $budget->fechaEvento }}</td>
                                                                    @php
                                                                        $cliente = App\Client::where('id', $budget->client_id)->first();

                                                                        if($cliente->tipoPersona == "FISICA"){
                                                                            $clienteFisico = App\PhysicalPerson::where('client_id', $budget->client_id)->first();
                                                                            $clienteNombre = $clienteFisico->nombre.' '.$clienteFisico->apellidoPaterno.' '.$clienteFisico->apellidoMaterno;
                                                                        
                                                                        }else{
                                                                            $clienteMoral = App\MoralPerson::where('client_id', $budget->client_id)->first();
                                                                            $clienteNombre = $clienteMoral->nombre;
                                                                        }
                                                                    @endphp
                                                                    <td>{{$clienteNombre}}</td>
                                                                    @php
                                                                        if($budget->opcionIVA){
                                                                            $total = $budget->total * 0.16;
                                                                        }else{
                                                                            $total = $budget->total;
                                                                        }
                                                                    @endphp
                                                                    <td>{{ $total }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                    
                                @endforeach
                            
                            </tbody>
                     </table>
                            </div>
                        </div>
                </div>
                <!-- Vista presupuestos archivados -->
                <div class="content" id="presupuestosArchivados" style="display: none">
                <div class="block">
                    <div class="block-header block-header-default">
                        <div class="col-md-3">
                        <h3 class="block-title" style="color:green">Comision por evento</h3>
                    </div>
                    <div class="col-md-9 text-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoPresupuesto">
                                    <i class="si si-printer"></i> <i>Imprimir Reporte</i> 
                                </button>
                                    <button onclick="PresupuestosActivos()" class="btn btn-success">
                                                <i  class="fa fa-calendar-minus-o"></i> <i>Comisión por vendedor</i> 
                                            </button>
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestosArchivados" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th># Contrato</th>
                                    <th>Fecha Evento</th>
                                    <th>Cliente</th>
                                    <th>Importe</th>
                                    <th>Comisión</th>
                                    <th>Vendedor</th>
                                     <th>Opciones</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>                    
                                                    
                                <tr role="row" class="odd">
                                    <td class="text-center sorting_1">NM10945</td>
                                    <td class="">Lunes 10/10/2019</td>
                                    <td class="d-none d-sm-table-cell">Mario Moreno</td>
                                    <td class="d-none d-sm-table-cell">$30,000</td>
                                    <td class="d-none d-sm-table-cell">$300</td>
                                    <td class="d-none d-sm-table-cell text-center">Laura Montaner</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Ver Perfil" data-original-title="View Customer">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            
                            </tbody>
                     </table>
                            </div>
                        </div>
                </div>
               
    </section>
   
    @include('../modals/nuevoClienteModal')
    @include('../modals/tiposEmpresaModal')
    @include('../modals/comoSupoModal')
    @include('../modals/settingsMaster')
@endsection
@section("scripts")
<script>
function archivarCliente(){
    Swal.fire({
                                title: '¿Estas seguro de archivar este presupuesto?',
                                text: "Al archivar un presupuesto dejara de estar disponible en la tabla de presupuestos",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Confirmar'
                                
                            }).then((result) => {
                            if (result.value) {
                                var url= '/presupuestos/eliminar-presupuestos/'+task;
                                axios.delete(url).then(response =>{
                                    this.obtenerTareas();
                                    }) 
                                }
                          
})
   }
function presupuestosArchivados(){
    document.getElementById('presupuestosArchivados').style.display="block";
    document.getElementById('PresupuestosActivos').style.display="none";
}
function PresupuestosActivos(){
    document.getElementById('presupuestosArchivados').style.display="none";
    document.getElementById('PresupuestosActivos').style.display="block";
}
</script>

@endsection