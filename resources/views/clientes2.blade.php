@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')
    @if (session('info'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if (count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <section class="container">
            @php
        
            $usuario = Auth::user()->id; 
            $permisos = App\Permission::where('user_id', $usuario)->first();   
        @endphp
        <div class="row">
            <div class="col-md-4 text-center">
                
            </div>
            
           
        </div>
        <div class="content" id="ClientesActivos">
                <div class="block">
                    <div class="block-header block-header-default">
                        <div class="col-md-7">
                        <h3 class="block-title" style="color:green">Clientes Activos</h3>
                    </div>
                    <div class="col-md-5 text-right">
                            @if($permisos->clientesNuevoCliente==1)
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoClienteModal">
                                            <i class="fa fa-user-plus"></i> <i>Nuevo Cliente</i> 
                                        </button>
                            @endif
                            @if($permisos->clientesArchivados==1)
                                    <button onclick="VerArchivados()" class="btn btn-secondary">
                                                <i class="fa fa-user-times"></i> <i>Clientes Archivados</i> 
                                            </button>
                            @endif
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                    <table style="font-size: 11px;" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaInventario" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Imagen</th>
                                    <th>Servicio</th>
                                    <th>Total bodega</th>
                                    <th>Total exhibición</th>
                                    <th>Precio Unitario</th>
                                    <th>Proveedor</th>
                                    <th>Familia</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            
                     </table>
                            </div>
                        </div>
                </div>
              
                <!--
                <div class="content" id="ClientesArchivados" style="display: none">
                        <div class="block">
                            <div class="block-header block-header-default">
                                <div class="col-md-7">
                                <h3 class="block-title" style="color:indianred">Clientes Archivados</h3>
                            </div>
                            <div class="col-md-5 text-right">
                                   
                                            <button onclick="VerActivos()" class="btn btn-success">
                                                        <i class="si si-user-following"></i> <i>Ver Clientes Activos</i> 
                                                    </button>
                            </div>
                            </div>
                            <div style="padding:15px; padding-top:30px;">
                             <table style="font-size: 12px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaClientesArchivados" role="grid" >
                                    <thead>
                                        <tr role="row">
                                            <th class="text-center sorting_asc"  rowspan="1" colspan="1"></th>
                                            <th class="sorting" rowspan="1" colspan="1">Nombre</th>
                                            <th class="d-none d-sm-table-cell sorting"  rowspan="1" colspan="1">Fecha Registro</th>
                                            <th class="d-none d-sm-table-cell sorting" rowspan="1" colspan="1">Numero Telefonico</th>
                                            <th rowspan="1" colspan="1">Correo Electronico</th>
                                            <th rowspan="1" colspan="1">Presupuestos</th>
                                            <th rowspan="1" colspan="1">Opciones</th></tr>
                                        </tr>
                                    </thead>
                                    <tbody>                    
                                              
                                        <tr role="row" class="odd">
                                        <td class="text-center sorting_1">id</td>
                                            <td class="font-w600">nombre</td>
                                            <td class="d-none d-sm-table-cell">10/10/2019</td>
                                            <td class="d-none d-sm-table-cell">cliente@cliente.com</td>
                                            <td class="d-none d-sm-table-cell">Cliente@cliente.com</td>
                                            <td class="d-none d-sm-table-cell">12</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Ver Perfil" data-original-title="View Customer">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                                <button type="button" onclick="restaurarCliente()" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Archivas Contacto" data-original-title="View Customer">
                                                        <i class="fa fa-upload"></i>
                                                    </button>
                                            </td>
                                        </tr>
                                         
                                    
                                    </tbody>
                             </table>
                                    </div>
                                </div>
                        </div> Tabla archivados -->
               
    </section>
   
    @include('../modals/nuevoClienteModal')
    @include('../modals/tiposEmpresaModal')
    @include('../modals/comoSupoModal')
@endsection
@section("scripts")
<script>
$(document).ready( function () {
    $('#TablaInventario').DataTable({ 
        "serverSide" : true,
        "ajax" : "{{ url('api/inventariott')}}",
        "columns": [
            {data: 'img'},
            {data: 'servicio'},
            {data: 'cantidad'},
            {data: 'exhibicion'},
            {data: 'precioUnitario'},
            {data: 'proveedor1'},
            {data: 'familia'},
            {data: 'btn'},
        ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pageLength": 50,
        
    });
} ); 
</script>
<script>
    
function archivarCliente(){
    Swal.fire({
                                title: '¿Estas seguro de archivar a este cliente?',
                                text: "Al archivar un cliente no se eliminan sus registros, pero este ya no estara disponible en la creacion de presupuestos, ni en la lista de clientes",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Confirmar'
                                
                            }).then((result) => {
                            if (result.value) {
                                var url= '/tareas/archivar-cliente/'+task;
                                axios.delete(url).then(response =>{
                                    this.obtenerTareas();
                                    }) 
                                }
                          
})
   }
   function restaurarCliente(){
    Swal.fire({
                                title: '¿Estas seguro de restaurar a este cliente?',
                                text: "El cliente volvera a estar disponible para todas las operaciones que involucre clientes",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Confirmar'
                                
                            }).then((result) => {
                            if (result.value) {
                                var url= '/tareas/archivar-cliente/'+task;
                                axios.delete(url).then(response =>{
                                    this.obtenerTareas();
                                    }) 
                                }
                          
})
   }

function VerArchivados(){
    document.getElementById('ClientesArchivados').style.display="block";
    document.getElementById('ClientesActivos').style.display="none";
}
function VerActivos(){
    document.getElementById('ClientesArchivados').style.display="none";
    document.getElementById('ClientesActivos').style.display="block";
}
</script>

@endsection