@extends('layouts.backend')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<style>
        table.dataTable td{
        box-sizing: inherit;
        }
        </style>
@endsection

@section('content')
    <section class="container">
        
        <div class="content" id="PresupuestosActivos">
                <div class="block" id="divLista">
                    <div class="block-header block-header-default">
                        <div class="col-md-6">
                        <h3 class="block-title" style="color:green">Editar Permisos de {{$Usuario->name}}</h3>
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                          

                    <form action="{{route('editar.permisos', $Permisos->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-3">
                                    <label style="font-weight: bold"><input type="hidden" name="user_id" value="{{$Permisos->user_id}}">
                                    <input style="font-weight: bold" type="checkbox" name="dashboard" value="1" @if($Permisos->dashboard==1) checked @endif>-Dashboard</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardCrearPresupuesto" value="1" @if($Permisos->dashboardCrearPresupuesto==1) checked @endif>-Crear Presupuesto</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardNuevoCliente" value="1" @if($Permisos->dashboardNuevoCliente==1) checked @endif>-Nuevo cliente</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardReporteVentas" value="1" @if($Permisos->dashboardReporteVentas==1) checked @endif>-Reporte de ventas</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardConfiguraciones" value="1" @if($Permisos->dashboardConfiguraciones==1) checked @endif>-Configuración de comisiones</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardAperturaCaja" value="1" @if($Permisos->dashboardAperturaCaja==1) checked @endif>-Apertura de caja</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardPresupuestosActivos" value="1" @if($Permisos->dashboardPresupuestosActivos==1) checked @endif>-Presupuestos activos</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardContratosHoy" value="1" @if($Permisos->dashboardContratosHoy==1) checked @endif>-Contratos hoy</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardElementosDanados" value="1" @if($Permisos->dashboardElementosDanados==1) checked @endif>-Elementos dañados</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardCreditosAtrasados" value="1" @if($Permisos->dashboardCreditosAtrasados==1) checked @endif>-Creditos atrasados</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardComponenteVentas" value="1" @if($Permisos->dashboardComponenteVentas==1) checked @endif>-Componente ventas</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardComponenteContabilidad" value="1" @if($Permisos->dashboardComponenteContabilidad==1) checked @endif>-Componente ingresos/egresos</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardListaTareas" value="1" @if($Permisos->dashboardListaTareas==1) checked @endif>-Lista tareas</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardCalendario" value="1" @if($Permisos->dashboardCalendario==1) checked @endif>-Calendario</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardVendedorMes" value="1" @if($Permisos->dashboardVendedorMes==1) checked @endif>-Vendedor del mes</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="dashboardVentasMes" value="1" @if($Permisos->dashboardVentasMes==1) checked @endif>-Ranking ventas del mes</label><br>
                            </div>
                            <div class="col-md-3">
                                    <label style="font-weight: bold"><input style="font-weight: bold" type="checkbox" name="clientes" value="1" @if($Permisos->clientes==1) checked @endif>-Clientes</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="clientesNuevoCliente" value="1" @if($Permisos->clientesNuevoCliente==1) checked @endif>-Nuevo cliente</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="clientesArchivados" value="1" @if($Permisos->clientesArchivados==1) checked @endif>-Clientes archivados</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="clientesEditar" value="1" @if($Permisos->clientesEditar==1) checked @endif>-Editar cliente</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="clientesArchivar" value="1" @if($Permisos->clientesArchivar==1) checked @endif>-Archivar cliente</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="clientesId" value="1" @if($Permisos->clientesId==1) checked @endif>-Ver ID</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="clientesNombre" value="1" @if($Permisos->clientesNombre==1) checked @endif>-Ver Nombre</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="clientesFechaRegistro" value="1" @if($Permisos->clientesFechaRegistro==1) checked @endif>-Ver fecha de registro</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="clientesNumeroTelefono" value="1" @if($Permisos->clientesNumeroTelefono==1) checked @endif>-Ver numero de telefono</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="clientesCorreoElectronico" value="1" @if($Permisos->clientesCorreoElectronico==1) checked @endif>-Ver correo electronico</label><br>
                                    
                            </div>
                            <div class="col-md-3">
                                    <label style="font-weight: bold"><input style="font-weight: bold" type="checkbox" name="contratos" value="1" @if($Permisos->contratos==1) checked @endif>-Contratos</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosFolio" value="1" @if($Permisos->contratosFolio==1) checked @endif>-Ver Folio</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosFecha" value="1" @if($Permisos->contratosFecha==1) checked @endif>-Ver Fecha de Evento</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosCliente" value="1" @if($Permisos->contratosCliente==1) checked @endif>-Ver Cliente</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosVendedor" value="1" @if($Permisos->contratosVendedor==1) checked @endif>-Ver Vendedor</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosVersion" value="1" @if($Permisos->contratosVersion==1) checked @endif>-Ver Versión</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosImpresionCliente" value="1" @if($Permisos->contratosImpresionCliente==1) checked @endif>-Imprimir PDF cliente</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosEnviarCorreo" value="1" @if($Permisos->contratosEnviarCorreo==1) checked @endif>-Enviar Correo</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosImprimirBodega" value="1" @if($Permisos->contratosImprimirBodega==1) checked @endif>-Imprimir Ficha de Bodega</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosUltimaModificacion" value="1" @if($Permisos->contratosUltimaModificacion==1) checked @endif>-Ver Ultima Actualización</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosTotal" value="1" @if($Permisos->contratosTotal==1) checked @endif>-Ver Total</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosEditar" value="1" @if($Permisos->contratosEditar==1) checked @endif>-Editar Contrato</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosFichaTecnica" value="1" @if($Permisos->contratosFichaTecnica==1) checked @endif>-Ficha Tecnica</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosArchivar" value="1" @if($Permisos->contratosArchivar==1) checked @endif>-Archivar Contrato</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosCrearContrato" value="1" @if($Permisos->contratosCrearContrato==1) checked @endif>-Crear Contrato</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosVistaCalendario" value="1" @if($Permisos->contratosVistaCalendario==1) checked @endif>-Vista Calendario</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosArchivados" value="1" @if($Permisos->contratosArchivados==1) checked @endif>-Contratos Archivados</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="contratosHistorial" value="1" @if($Permisos->contratosHistorial==1) checked @endif>-Historial</label><br>
                                
                            </div>
                            <div class="col-md-3">
                                    <label style="font-weight: bold"><input style="font-weight: bold" type="checkbox" name="presupuestos" value="1" @if($Permisos->presupuestos==1) checked @endif>-Presupuestos</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosFolio" value="1" @if($Permisos->presupuestosFolio==1) checked @endif>-Ver Folio</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosFecha" value="1" @if($Permisos->presupuestosFecha==1) checked @endif>-Ver Fecha de Evento</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosCliente" value="1" @if($Permisos->presupuestosCliente==1) checked @endif>-Ver Cliente</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosVendedor" value="1" @if($Permisos->presupuestosVendedor==1) checked @endif>-Ver Vendedor</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosVersion" value="1" @if($Permisos->presupuestosVersion==1) checked @endif>-Ver Versión</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosImpresionCliente" value="1" @if($Permisos->presupuestosImpresionCliente==1) checked @endif>-Imprimir PDF cliente</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosEnviarCorreo" value="1" @if($Permisos->presupuestosEnviarCorreo==1) checked @endif>-Enviar Correo</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosImprimirBodega" value="1" @if($Permisos->presupuestosImprimirBodega==1) checked @endif>-Imprimir Ficha de Bodega</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosUltimaModificacion" value="1" @if($Permisos->presupuestosUltimaModificacion==1) checked @endif>-Ver Ultima Actualización</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosTotal" value="1" @if($Permisos->presupuestosTotal==1) checked @endif>-Ver Total</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosEditar" value="1" @if($Permisos->presupuestosEditar==1) checked @endif>-Editar Contrato</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosFichaTecnica" value="1" @if($Permisos->presupuestosFichaTecnica==1) checked @endif>-Ficha Tecnica</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosArchivar" value="1" @if($Permisos->presupuestosArchivar==1) checked @endif>-Archivar Contrato</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosCrearContrato" value="1" @if($Permisos->presupuestosCrearContrato==1) checked @endif>-Crear Contrato</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosVistaCalendario" value="1" @if($Permisos->presupuestosVistaCalendario==1) checked @endif>-Vista Calendario</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosArchivados" value="1" @if($Permisos->presupuestosArchivados==1) checked @endif>-Contratos Archivados</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="presupuestosHistorial" value="1" @if($Permisos->presupuestosHistorial==1) checked @endif>-Historial</label><br>
                            </div>
                                
                        </div>
                        <div class="row" style="padding-top: 20px; border-top:solid; border-width: 1px; margin-top: 20px">
                            <div class="col-md-3">
                                    <label style="font-weight: bold">-Creación de Presupuestos</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="creacionEditarVendedor" value="1" @if($Permisos->creacionEditarVendedor==1) checked @endif>-Editar Vendedor</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="creacionAdministrarCategorias" value="1" @if($Permisos->creacionAdministrarCategorias==1) checked @endif>-Administrar categorias</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="creacionNuevoCliente" value="1" @if($Permisos->creacionNuevoCliente==1) checked @endif>-Nuevo Cliente</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="creacionGuardarComoContrato" value="1" @if($Permisos->creacionGuardarComoContrato==1) checked @endif>-Guardar como contrato</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="creacionSettings" value="1" @if($Permisos->creacionSettings==1) checked @endif>-Configuraciones</label><br>
                                    
                                    <label style="font-weight: bold"><input style="font-weight: bold" type="checkbox" name="comisiones" value="1" @if($Permisos->comisiones==1) checked @endif>-Comisiones</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="comisionesImprimirReporte" value="1" @if($Permisos->comisionesImprimirReporte==1) checked @endif>-Ver Folio</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="comisionesConfigurarComisiones" value="1" @if($Permisos->comisionesConfigurarComisiones==1) checked @endif>-Configurar Comisiones</label><br>
                                    
                                    <label style="font-weight: bold"><input style="font-weight: bold" type="checkbox" name="ventas" value="1" @if($Permisos->ventas==1) checked @endif>-ventas</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="ventasImprimirReporte" value="1" @if($Permisos->ventasImprimirReporte==1) checked @endif>-Imprir Reporte</label><br>

                                    <label style="font-weight: bold"><input style="font-weight: bold" type="checkbox" name="usuarios" value="1" @if($Permisos->usuarios==1) checked @endif>-Usuarios</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="usuariosEditar" value="1" @if($Permisos->usuariosEditar==1) checked @endif>-Editar Usuarios</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="usuariosActivarDesactivar" value="1" @if($Permisos->usuariosActivarDesactivar==1) checked @endif>-Activar Desactivar</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="usuariosPermisos" value="1" @if($Permisos->usuariosPermisos==1) checked @endif>-Editar Permisos</label><br>

                            </div>
                            <div class="col-md-3">
                                    <label style="font-weight: bold"><input style="font-weight: bold" type="checkbox" name="inventarioInventario" value="1" @if($Permisos->inventarioInventario==1) checked @endif>-Opción inventario en menú</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioFamilias" value="1" @if($Permisos->inventarioFamilias==1) checked @endif>-Opción familias en men</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioGrupos" value="1" @if($Permisos->inventarioGrupos==1) checked @endif>-Opción grupos en men</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioAgregarFamilia" value="1" @if($Permisos->inventarioAgregarFamilia==1) checked @endif>-Agregar Familia</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioAgregarProducto" value="1" @if($Permisos->inventarioAgregarProducto==1) checked @endif>-Agregar Producto</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioCrearPaquete" value="1" @if($Permisos->inventarioCrearPaquete==1) checked @endif>-Crear Paquete</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioEditar" value="1" @if($Permisos->inventarioEditar==1) checked @endif>-Editar Producto</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioArchivar" value="1" @if($Permisos->inventarioArchivar==1) checked @endif>-Archivar Producto</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioAltasBajas" value="1" @if($Permisos->inventarioAltasBajas==1) checked @endif>-Altas y bajas de producto</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioImprimirFamilia" value="1" @if($Permisos->inventarioImprimirFamilia==1) checked @endif>-Imprimir Familia</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioTotalBodega" value="1" @if($Permisos->inventarioTotalBodega==1) checked @endif>-Ver total en bodega</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioTotalExhibicion" value="1" @if($Permisos->inventarioTotalExhibicion==1) checked @endif>-Ver total en exhibición</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioPrecioUnitario" value="1" @if($Permisos->inventarioPrecioUnitario==1) checked @endif>-Ver Precio Unitario</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioProveedor" value="1" @if($Permisos->inventarioProveedor==1) checked @endif>-Ver Proveedor</label><br>
                                    <input style="margin-left: 20px" type="checkbox" name="inventarioFamilia" value="1" @if($Permisos->inventarioFamilia==1) checked @endif>-Ver Familia</label><br>
                            </div>
                        </div>
                            <label for="">
                            
                        <button type="submit" class="btn btn-info" style="margin: 20px">Actualizar</button>
                        </form>
                    </div>
                    </div>
                </div>
              

     
          
    </section>
   
    
    @include('../modals/nuevoPresupuestoModal')
    @include('../modals/categoriaEventoModal')
    @include('../modals/nuevoProductoModal')
    @include('../modals/nuevoClienteModal')
@endsection

@section("scripts")
    <script>
        function vista_calendario(){
        document.getElementById('divCalendario').style.display="block";
        document.getElementById('divLista').style.display="none";
    }
    function vista_lista(){
        document.getElementById('divCalendario').style.display="none";
        document.getElementById('divLista').style.display="block";
    }
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
    function enviarCorreoCliente(id){
                let URL = '/enviar-email-cliente/'  + id;

                axios.get(URL).then((response) => {
                    Swal.fire(
                            'Enviado!',
                            'El presupuesto ha sido enviado por correo',
                            'success'
                        ); 
                }).catch((error) => {
                    console.log(error.data);
                    Swal.fire(
                            'Error!',
                            'A ocurrido un error al enviar el correo, intentar mas tarde',
                            'Danger'
                        ); 
                })
            }
    function presupuestosArchivados(){
        document.getElementById('presupuestosArchivados').style.display="block";
        document.getElementById('PresupuestosActivos').style.display="none";
        document.getElementById('PresupuestosHistorial').style.display="none";
    }
    function PresupuestosActivos(){
        document.getElementById('presupuestosArchivados').style.display="none";
        document.getElementById('PresupuestosActivos').style.display="block";
        document.getElementById('PresupuestosHistorial').style.display="none";
    }
    function PresupuestosHistorial(){
        document.getElementById('presupuestosArchivados').style.display="none";
        document.getElementById('PresupuestosActivos').style.display="none";
        document.getElementById('PresupuestosHistorial').style.display="block";
    }
    </script>

@endsection

