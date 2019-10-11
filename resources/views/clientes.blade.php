@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')

    <section class="container">
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
                           
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoClienteModal">
                                            <i class="fa fa-user-plus"></i> <i>Nuevo Cliente</i> 
                                        </button>
                                    <button onclick="VerArchivados()" class="btn btn-secondary">
                                                <i class="fa fa-user-times"></i> <i>Clientes Archivados</i> 
                                            </button>
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table style="font-size: 12px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaClientes" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th class="text-center sorting_asc"  rowspan="1" colspan="1"></th>
                                    <th class="sorting" rowspan="1" colspan="1">Nombre</th>
                                    <th class="d-none d-sm-table-cell sorting"  rowspan="1" colspan="1">Fecha Registro</th>
                                    <th class="d-none d-sm-table-cell sorting" rowspan="1" colspan="1">Numero Telefonico</th>
                                    <th rowspan="1" colspan="1">Correo Electrónico</th>
                                    <th rowspan="1" colspan="1">Presupuestos</th>
                                    <th rowspan="1" colspan="1">Opciones</th></tr>
                                </tr>
                            </thead>
                            <tbody>                    
                                    @foreach ($CompleteClients as $cliente)                     
                                <tr role="row" class="odd">
                                <td class="text-center sorting_1">{{$cliente->id}}</td>
                                    <td class="font-w600">{{$cliente->nombre}} 
                                        @if(array_key_exists('apellidoPaterno', $cliente))
                                        {{$cliente->apellidoPaterno}}
                                        @endif

                                        </td>
                                    <td class="d-none d-sm-table-cell">{{$cliente->created_at}}</td>
                                    <td class="d-none d-sm-table-cell">{{$cliente->telefono}}</td>
                                    <td class="d-none d-sm-table-cell">{{$cliente->email}}</td>
                                    <td class="d-none d-sm-table-cell">{{$cliente->presupuestos}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('cliente.edit', $cliente->id) }}" class="btn btn-sm btn-primary " data-toggle="tooltip" title="Editar Cliente"  data-original-title="View Customer">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <button type="button" onclick="archivarCliente()" class="btn btn-sm btn-danger " data-toggle="tooltip" title="Archivar Cliente">
                                                <i class="si si-refresh"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            
                            </tbody>
                     </table>
                            </div>
                        </div>
                </div>
              
                <!--Tabla archivados -->
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