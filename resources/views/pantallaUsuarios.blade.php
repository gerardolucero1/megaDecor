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
                        <button class="btn btn-primary" data-toggle="modal" data-target="#agregarUsuario">
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
                                <th rowspan="1" colspan="1">Tipo</th>
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
                                    <td class="d-none d-sm-table-cell">{{$usuario->tipo}}</td>
                                    <td class="d-none d-sm-table-cell"><p style="color:@if($usuario->archivado==0) green @else red @endif">@if($usuario->archivado==0) Activo @else Inactivo @endif</p></td>
                                    <td class="text-center">
                                        <a href="{{ route('usuario.permisos', $usuario->id) }}" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Ver Permisos de usuario" data-original-title="View Customer">
                                            <i class="si si-settings"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $usuario->id) }}" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Ver Perfil" data-original-title="View Customer">
                                            <i class="fa fa-edit"></i>
                                        </a>
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


                
                        <!-- modal nuevo usuario -->
<div class="modal fade modalAgregarPaquete" id="agregarPaquete" tabindex="-1" role="dialog" aria-labelledby="agregarElemento" aria-hidden="true" style="overflow-y: scroll;">
        <div id="app" class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" style="border: solid gray">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Nuevo Usuario</h5>
                <div  class="close" onClick="$('#agregarPaquete').modal('hide')" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </div>
            </div>
           
        
            </div>
        </div>
    </div>

    <!-- Modal agregar usuario -->
    <div class="modal fade" id="agregarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Nuevo usuario</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Nombre</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Email</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Contraseña</label>
                            <input oninput="confirmarPassword()" type="password" name="password" id="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Confirmar Contraseña</label>
                            <input oninput="confirmarPassword()" type="password" name="passwordConfirmacion" id="passwordConfirmacion" class="form-control" required>
                            <p style="color: red; font-style: italic; text-align:center; display:none" id="mensajeError" >*Las Contraseñas no coinciden</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Tipo de usuario</label>
                            <select name="tipo" id="" class="form-control">
                                <option value="ADMINISTRADOR">Administrador</option>
                                <option value="GERENCIA">Gerente</option>
                                <option value="VENTAS">Vendedor</option>
                                <option value="CONTABILIDAD">Contabilidad</option>
                                <option value="BODEGA">Bodega</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Crear</button>
                        <button type="submit" class="btn btn-primary" id="btnSave">Crear Usuario</button>
                    </div>
                </form>
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

function confirmarPassword(){
    let pass1 = document.getElementById('password').value;
    let pass2 = document.getElementById('passwordConfirmacion').value;
    if(pass1==pass2){
    document.getElementById('mensajeError').style.display="none";
    document.getElementById('btnSave').style.display="block";
    }else{
    document.getElementById('mensajeError').style.display="block";
    document.getElementById('btnSave').style.display="none";
        }
}
</script>

@endsection