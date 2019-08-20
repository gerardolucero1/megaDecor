@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')

    <section class="container">
        <div class="row">
                <div class="col-md-4 text-center">
                        <button class="btn btn-success" data-toggle="modal" data-target="#nuevoPresupuestoModal">
                            Nuevo Presupuesto
                        </button>
                    </div>
            
           
        </div>
        <div class="content" id="PresupuestosActivos">
                <div class="block">
                    <div class="block-header block-header-default">
                        <div class="col-md-3">
                        <h3 class="block-title" style="color:green">Presupuestos Activos</h3>
                    </div>
                    <div class="col-md-9 text-right">
                           
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoPresupuesto">
                                            <i class="fa fa-calendar-plus-o"></i> <i>Crear Presupuesto</i> 
                                        </button>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoPresupuesto">
                                                <i class="fa fa-calendar"></i> <i>Vista Calendario</i> 
                                            </button>
                                    <button onclick="presupuestosArchivados()" class="btn btn-secondary">
                                                <i class="fa fa-calendar-minus-o"></i> <i>Presupuestos Archivados</i> 
                                            </button>
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>#Presupuesto</th>
                                    <th>Fecha Evento</th>
                                    <th>Cliente</th>
                                    <th>Lugar</th>
                                    <th>Vendedor</th>
                                    <th>Version</th>
                                     <th>Ultima Modificación</th>
                                     <th>Opciones</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>                    
                                                    
                                <tr role="row" class="odd">
                                    <td class="text-center sorting_1">NM10945</td>
                                    <td class="">Lunes 10/10/2019</td>
                                    <td class="d-none d-sm-table-cell">Jose Moreno</td>
                                    <td class="d-none d-sm-table-cell">Jardin San Jose</td>
                                    <td class="d-none d-sm-table-cell">Karen</td>
                                    <td class="d-none d-sm-table-cell text-center">3/3</td>
                                    <td class="d-none d-sm-table-cell">10/10/2019</td>
                                    
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Ver Perfil" data-original-title="View Customer">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button type="button" onclick="archivarCliente()" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Archivas Contacto" data-original-title="View Customer">
                                                <i class="fa fa-remove"></i>
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
                        <h3 class="block-title" style="color:indianred">Presupuestos Archivados</h3>
                    </div>
                    <div class="col-md-9 text-right">
                           
                                    <button onclick="PresupuestosActivos()" class="btn btn-success">
                                                <i  class="fa fa-calendar-minus-o"></i> <i>Presupuestos Activos</i> 
                                            </button>
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestosArchivados" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>#Presupuesto</th>
                                    <th>Fecha Evento</th>
                                    <th>Cliente</th>
                                    <th>Lugar</th>
                                    <th>Vendedor</th>
                                    <th>Version</th>
                                     <th>Ultima Modificación</th>
                                     <th>Opciones</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>                    
                                                    
                                <tr role="row" class="odd">
                                    <td class="text-center sorting_1">NM10945</td>
                                    <td class="">Lunes 10/10/2019</td>
                                    <td class="d-none d-sm-table-cell">Mario Moreno</td>
                                    <td class="d-none d-sm-table-cell">Jardin San Jose</td>
                                    <td class="d-none d-sm-table-cell">Karen</td>
                                    <td class="d-none d-sm-table-cell text-center">3/3</td>
                                    <td class="d-none d-sm-table-cell">10/10/2019</td>
                                    
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Ver Perfil" data-original-title="View Customer">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button type="button" onclick="archivarCliente()" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Archivas Contacto" data-original-title="View Customer">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                    </td>
                                </tr>
                            
                            </tbody>
                     </table>
                            </div>
                        </div>
                </div>
               
    </section>
   
    
    @include('../modals/nuevoPresupuestoModal')
    @include('../modals/nuevoProductoModal')
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
