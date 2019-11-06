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
                        <h3 class="block-title" style="color:green">Usuarios Activos</h3>
                    </div>
                    <div class="col-md-5 text-right">
                           
                    <button  class="btn btn-primary" data-toggle="modal" data-target="#agregarPaquete">
                                            <i class="fa fa-user-plus"></i> <i>Nuevo Usario</i> 
                                    </button>
                                    <button onclick="VerArchivados()" class="btn btn-secondary">
                                                <i class="fa fa-user-times"></i> <i>Usuarios Archivados</i> 
                                            </button>
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table style="font-size: 12px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaClientes" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th class="text-center sorting_asc"  rowspan="1" colspan="1"></th>
                                    <th class="sorting" rowspan="1" colspan="1">Usuario</th>
                                    <th class="d-none d-sm-table-cell sorting"  rowspan="1" colspan="1">Correo Electronico</th>
                                    <th rowspan="1" colspan="1">Creación</th>
                                    <th rowspan="1" colspan="1">Status</th>
                                    <th rowspan="1" colspan="1">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>                    
                                     
                                @foreach ($Usuarios as $usuario)  
                                <tr role="row" class="odd">
                                <td class="text-center sorting_1">{{$usuario->id}}</td>
                                <td class="text-center sorting_1">{{$usuario->name}}</td>
                                    <td class="d-none d-sm-table-cell">{{$usuario->email}}</td>
                                    <td class="d-none d-sm-table-cell">{{$usuario->created_at}}</td>
                                    <td class="d-none d-sm-table-cell"><p style="color:@if($usuario->archivado==0) green @else red @endif">@if($usuario->archivado==0) Activo @else Inactivo @endif</p></td>
                                    <td class="text-center">
                                    <a href="{{ route('usuario.permisos', $usuario->id) }}" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Ver Perfil" data-original-title="View Customer">
                                                    <i class="si si-settings"></i>
                                            </a>
                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Ver Perfil" data-original-title="View Customer">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <a href="{{route('usuario.archivar', $usuario->id)}}" type="button"  class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Archivas Contacto" data-original-title="View Customer">
                                                <i class="si si-refresh"></i>
                                            </a>
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
                                <h3 class="block-title" style="color:indianred">Usuarios Archivados</h3>
                            </div>
                            <div class="col-md-5 text-right">
                                   
                                            <button onclick="VerActivos()" class="btn btn-success">
                                                        <i class="si si-user-following"></i> <i>Ver Usuarios Activos</i> 
                                                    </button>
                            </div>
                            </div>
                            <div style="padding:15px; padding-top:30px;">
                             <table style="font-size: 12px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaClientesArchivados" role="grid" >
                                    <thead>
                                        <tr role="row">
                                                <th class="text-center sorting_asc"  rowspan="1" colspan="1"></th>
                                                <th class="sorting" rowspan="1" colspan="1">Usuario</th>
                                                <th class="d-none d-sm-table-cell sorting"  rowspan="1" colspan="1">Numero</th>
                                                <th class="d-none d-sm-table-cell sorting" rowspan="1" colspan="1">Contraseña</th>
                                                <th rowspan="1" colspan="1">Tipo</th>
                                                <th rowspan="1" colspan="1">Opciones</th>
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
                        <!-- modal paquete -->
<div class="modal fade modalAgregarPaquete" id="agregarPaquete" tabindex="-1" role="dialog" aria-labelledby="agregarElemento" aria-hidden="true" style="overflow-y: scroll;">
        <div id="app" class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" style="border: solid gray">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Nuevo Usuario</h5>
                <div  class="close" onClick="$('#agregarPaquete').modal('hide')" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4"> 
                        <label for="">Nombre</label><br>
                        <input type="text" placeholder="Nombre" style="border:solid; border-width:1px; border-radius:5px; padding:5px;">
                    </div>
                    <div class="col-md-4">
                         <label for="">Apellido Paterno</label><br>
                        <input type="text" placeholder="Apellido Paterno" style="border:solid; border-width:1px; border-radius:5px; padding:5px;">
                    </div>
                    <div class="col-md-4">
                        <label for="">Apellido Materno</label><br>
                        <input type="text" placeholder="Apellido Materno" style="border:solid; border-width:1px; border-radius:5px; padding:5px;">
                    </div>
                    <div class="col-md-4">
                        <label for="">Teléfono</label><br>
                        <input type="text" placeholder="Numero Telefonico" style="border:solid; border-width:1px; border-radius:5px; padding:5px;">
                        </div>
                    <div class="col-md-4">
                        <label for="">Rol de usuario</label><br>
                        <select name="" id="">
                            <option value="">Administrador</option>
                            <option value="">Vendedor</option>
                            <option value="">Caja</option>
                            <option value="">Contabilidad</option>
                            <option value="">Operador</option>
                        </select>           
                    </div>
                </div>
                <div class="row" style="padding-top: 25px">
                        <div class="col-md-4">
                            <input type="text" placeholder="Correo Electronico" style="border:solid; border-width:1px; border-radius:5px; padding:5px;">
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="Contraseña" style="border:solid; border-width:1px; border-radius:5px; padding:5px;">
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="Confirmar contraseña" style="border:solid; border-width:1px; border-radius:5px; padding:5px;">
                        </div>
                </div>
                <div class="row" style="padding:30px; padding-top: 25px; padding-bottom: 0px;">
                    <label style="font-weight: bold" for="">Permisos de usuario</label>
                </div>
                <div class="row" style="padding: 50px; padding-top: 10px;">
                    <div class="col-md-4">
                                <label for=""><input type="checkbox"> Dashboard</label>
                                <label for="" style="padding-left: 30px"><input type="checkbox"> Crear Presupuesto</label>
                                <label for="" style="padding-left: 30px"><input type="checkbox"> Comparador de ventas</label>
                                <label for="" style="padding-left: 30px"><input type="checkbox"> Comparador de ingresos</label>
                                <label for="" style="padding-left: 30px"><input type="checkbox"> Calendario eventos</label>
                                <label for="" style="padding-left: 30px"><input type="checkbox"> Creacion de tareas</label>
                                <label for="" style="padding-left: 30px"><input type="checkbox"> Tabla de tareas</label>
                                <label for="" style="padding-left: 30px"><input type="checkbox"> Empleado del mes</label>
                            </div>
                            <div class="col-md-4">
                                    <label for=""><input type="checkbox"> Formulario Presupuesto</label>
                                    <label for="" style="padding-left: 30px"><input type="checkbox"> Administrar categorias</label>
                                    <label for="" style="padding-left: 30px"><input type="checkbox"> Guardar elementos externos</label>
                                    <label for="" style="padding-left: 30px"><input type="checkbox"> Guardar paquetes</label>
                                    <label for="" style="padding-left: 30px"><input type="checkbox"> Guardar como contrato</label>
                                    <label for="" style="padding-left: 30px"><input type="checkbox"> Editar precios unitarios</label>
                                </div>
                                <div class="col-md-4">
                                        <label for=""><input type="checkbox"> Pantalla Presupuestos</label>
                                        <label for="" style="padding-left: 30px"><input type="checkbox"> Imprimir</label>
                                        <label for="" style="padding-left: 30px"><input type="checkbox"> Editar</label>
                                        <label for="" style="padding-left: 30px"><input type="checkbox"> Ver ficha tecnica</label>
                                        <label for="" style="padding-left: 30px"><input type="checkbox"> Imprimir</label>
                                        <label for="" style="padding-left: 30px"><input type="checkbox"> Enviar por correo</label>
                                    </div>
                                    <div class="col-md-4" style="padding-top: 20px">
                                            <label for=""><input type="checkbox"> Pantalla Contratos</label>
                                            <label for="" style="padding-left: 30px"><input type="checkbox"> Imprimir</label>
                                            <label for="" style="padding-left: 30px"><input type="checkbox"> Editar</label>
                                            <label for="" style="padding-left: 30px"><input type="checkbox"> Ver ficha tecnica</label>
                                            <label for="" style="padding-left: 30px"><input type="checkbox"> Imprimir</label>
                                            <label for="" style="padding-left: 30px"><input type="checkbox"> Enviar por correo</label>
                                        </div>
                
            </div>
            
            <div class="modal-footer">
                <div  class="btn btn-secondary" onClick="$('#agregarPaquete').modal('hide')">Close</div>
                <div  class="btn btn-primary" >Agregar Usuario</div>
            </div>
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
    
function archivarUsuario(){
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
                                var url= 'archivar-usuario/'+task;
                                axios.delete(url).then(response =>{
                                   location.reload();
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