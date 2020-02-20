@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')
@php
        
        $usuario = Auth::user()->id; 
        $permisos = App\Permission::where('user_id', $usuario)->first();   
    @endphp
    <section class="container">

        <div class="row">
                       
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
                                    <a href="" class="btn btn-secondary">
                                                <i class="fa fa-calendar-minus-o"></i> <i>Comisiones por evento</i> 
                                            </a>
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Vendedor</th>
                                    <th># Ventas del mes</th>
                                    <th>Total Vendido</th>
                                    <th>Total Comisionable</th>
                                    <th>Total Comisión</th>
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
                                    $totalComisiones=0;
                                 @endphp    
                                
                                @foreach ($Vendedores as $vendedor)
                                            @php
                                                $totalVentas=0;
                                                $numeroVentas=0;
                                                $totalComisionable=0;
                                                $totalComision=0;
                                                $generalesComisiones = App\Commission::orderBy('id', 'ASC')->first();
                                                $ContratosDelMes = App\Budget::orderBy('id', 'ASC')->where('tipo', 'CONTRATO')->whereMonth('fechaEvento', $date)->where('vendedor_id', $vendedor->id)->get();
                                                //Obtenemos total de la ventas del mes
                                                foreach($ContratosDelMes as $contrato){
                                                    $totalVentas=$totalVentas+$contrato->total;
                                                    $numeroVentas++;
                                                
                                            if($contrato->total>=$generalesComisiones->minimoVentaComision){
                                                $inventarioContrato = App\BudgetInventory::where('budget_id', $contrato->id)->where('version', $contrato->version)->get();
                                                //Obtenemos total comisiobanle
                                                foreach($inventarioContrato as $servicio){
                                                    $totalComisionable=$totalComisionable+(($servicio->cantidad*$servicio->precioEspecial)-($servicio->precioVenta*$servicio->cantidad));
                                                }
                                                $totalComisionable=$totalComisionable;
                                                $totalComision=$totalComisionable*($generalesComisiones->comisionContrato/100);   
                                            
                                            }
                                        }
                                            @endphp
                                            <tr>
                                                <td>{{$vendedor->name}}</td>
                                                <td>{{$numeroVentas}}</td>
                                                <td>${{number_format($totalVentas,2)}}</td>
                                                <td>${{number_format($totalComisionable,2)}}</td>
                                                <td>${{number_format($totalComision,2)}}</td>
                                                @php
                                                    $totalComisiones=$totalComisiones+$totalComision;
                                                @endphp
                                            </tr>
                                             @endforeach
                                             <tr>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                             <td style="background: cornsilk; color: crimson; font-weight: bold">TOTAL: ${{number_format($totalComisiones,2)}}</td>
                                             </tr>
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