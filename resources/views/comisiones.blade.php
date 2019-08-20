@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')

    <section class="container">

        <div class="row" style="padding-left: 25px; padding-right:25px;">
                <div class="col-6 col-lg-4  col-xl-4"><a href="javascript:void(0)" class="block block-link-shadow text-right"><div class="block-content block-content-full clearfix"><div class="float-left mt-10 d-none d-sm-block"><i class="fa fa-star" style="font-size: 40px;"></i></div> 
                    <div class="font-size-h3 font-w600 js-count-to-enabled">Margarita Robles</div> 
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Ventas: 10</div></div></a></div>

                    <div class="col-6 col-lg-4  col-xl-4"><a href="javascript:void(0)" class="block block-link-shadow text-right">
                        <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                        <i class="fa fa-star" style="font-size: 40px;"></i></div> 
                        <div class="font-size-h3 font-w600 js-count-to-enabled">Margarita Robles</div> 
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Ventas: 10</div></div></a></div>
            
           
        </div>
    
        <div class="content">
        <button class="btn btn-secondary">
                <i class="si si-settings"></i> Configurar comisiones
             </button>
            </div>
            <div class="content" id="PresupuestosActivos">
            
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
                                                    
                                <tr role="row" class="odd">
                                    <td class="text-center sorting_1">Norma Serrano</td>
                                    <td class="">12</td>
                                    <td class="d-none d-sm-table-cell">Agosto</td>
                                    <td class="d-none d-sm-table-cell">$150,000</td>
                                    <td class="d-none d-sm-table-cell">$15,000</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Ver Lista de eventos" data-original-title="View Customer">
                                            <i class="fa fa-list-ul"></i>
                                        </button>
                                    </td>
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

@endsectiont