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
                          
                            <button class="btn btn-info" onclick="permisosAdministrador()">Administrador</button>
                            <button class="btn btn-info" onclick="permisosGerencia()">Gerencia</button>
                            <button class="btn btn-info" onclick="permisosVentas()">Ventas</button>
                            <button class="btn btn-info" onclick="permisosRecepcionista()">Recepcionista</button>
                            <button class="btn btn-info" onclick="permisosBodega()">Bodega</button>
                            <button class="btn btn-info" onclick="permisosContabilidad()">Contabilidad</button>
                    <form action="{{route('editar.permisos', $Permisos->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            
                            <div class="col-md-3">
                                    <label style="font-weight: bold"><input id="I1" type="hidden" name="user_id" value="{{$Permisos->user_id}}">
                                    <input id="I2" style="font-weight: bold" type="checkbox" name="dashboard" value="1" @if($Permisos->dashboard==1) checked @endif>-Dashboard</label><br>
                                    <input id="I3" style="margin-left: 20px" type="checkbox" name="dashboardCrearPresupuesto" value="1" @if($Permisos->dashboardCrearPresupuesto==1) checked @endif>-Crear Presupuesto</label><br>
                                    <input id="I4" style="margin-left: 20px" type="checkbox" name="dashboardNuevoCliente" value="1" @if($Permisos->dashboardNuevoCliente==1) checked @endif>-Nuevo cliente</label><br>
                                    <input id="I5" style="margin-left: 20px" type="checkbox" name="dashboardReporteVentas" value="1" @if($Permisos->dashboardReporteVentas==1) checked @endif>-Reporte de ventas</label><br>
                                    <input id="I6" style="margin-left: 20px" type="checkbox" name="dashboardConfiguraciones" value="1" @if($Permisos->dashboardConfiguraciones==1) checked @endif>-Configuración de comisiones</label><br>
                                    <input id="I7" style="margin-left: 20px" type="checkbox" name="dashboardAperturaCaja" value="1" @if($Permisos->dashboardAperturaCaja==1) checked @endif>-Apertura de caja</label><br>
                                    <input id="I8" style="margin-left: 20px" type="checkbox" name="dashboardPresupuestosActivos" value="1" @if($Permisos->dashboardPresupuestosActivos==1) checked @endif>-Presupuestos activos</label><br>
                                    <input id="I9" style="margin-left: 20px" type="checkbox" name="dashboardContratosHoy" value="1" @if($Permisos->dashboardContratosHoy==1) checked @endif>-Contratos hoy</label><br>
                                    <input id="I10" style="margin-left: 20px" type="checkbox" name="dashboardElementosDanados" value="1" @if($Permisos->dashboardElementosDanados==1) checked @endif>-Elementos dañados</label><br>
                                    <input id="I11" style="margin-left: 20px" type="checkbox" name="dashboardCreditosAtrasados" value="1" @if($Permisos->dashboardCreditosAtrasados==1) checked @endif>-Creditos atrasados</label><br>
                                    <input id="I12" style="margin-left: 20px" type="checkbox" name="dashboardComponenteVentas" value="1" @if($Permisos->dashboardComponenteVentas==1) checked @endif>-Componente ventas</label><br>
                                    <input id="I13" style="margin-left: 20px" type="checkbox" name="dashboardComponenteContabilidad" value="1" @if($Permisos->dashboardComponenteContabilidad==1) checked @endif>-Componente ingresos/egresos</label><br>
                                    <input id="I14" style="margin-left: 20px" type="checkbox" name="dashboardListaTareas" value="1" @if($Permisos->dashboardListaTareas==1) checked @endif>-Lista tareas</label><br>
                                    <input id="I15" style="margin-left: 20px" type="checkbox" name="dashboardCalendario" value="1" @if($Permisos->dashboardCalendario==1) checked @endif>-Calendario</label><br>
                                    <input id="I16" style="margin-left: 20px" type="checkbox" name="dashboardVendedorMes" value="1" @if($Permisos->dashboardVendedorMes==1) checked @endif>-Vendedor del mes</label><br>
                                    <input id="I17" style="margin-left: 20px" type="checkbox" name="dashboardVentasMes" value="1" @if($Permisos->dashboardVentasMes==1) checked @endif>-Ranking ventas del mes</label><br>
                                    <input id="" style="margin-left: 20px" type="checkbox" name="" value="1" @if($Permisos->dashboardVentasMes==1) checked @endif>-Entrar a Fletes</label><br>
                                    <input id="" style="margin-left: 20px" type="checkbox" name="" value="1" @if($Permisos->dashboardVentasMes==1) checked @endif>-Fletes Administrar Vehiculos</label><br>
                                    <input id="" style="margin-left: 20px" type="checkbox" name="" value="1" @if($Permisos->dashboardVentasMes==1) checked @endif>-Fletes Administrar casetas</label><br>
                                    <input id="" style="margin-left: 20px" type="checkbox" name="" value="1" @if($Permisos->dashboardVentasMes==1) checked @endif>-Vetar Clientes</label><br>
                                    <input id="" style="margin-left: 20px" type="checkbox" name="" value="1" @if($Permisos->dashboardVentasMes==1) checked @endif>-Restaurar Cliente Vetado</label><br>
                                    <input id="" style="margin-left: 20px" type="checkbox" name="" value="1" checked >-Contratos a nube para cambio de fecha</label><br>
                            </div>
                            <div class="col-md-3">
                                    <label id="I19" style="font-weight: bold"><input id="I18" style="font-weight: bold" type="checkbox" name="clientes" value="1" @if($Permisos->clientes==1) checked @endif>-Clientes</label><br>
                                    <input id="I20" style="margin-left: 20px" type="checkbox" name="clientesNuevoCliente" value="1" @if($Permisos->clientesNuevoCliente==1) checked @endif>-Nuevo cliente</label><br>
                                    <input id="I21" style="margin-left: 20px" type="checkbox" name="clientesArchivados" value="1" @if($Permisos->clientesArchivados==1) checked @endif>-Clientes archivados</label><br>
                                    <input id="I22" style="margin-left: 20px" type="checkbox" name="clientesEditar" value="1" @if($Permisos->clientesEditar==1) checked @endif>-Editar cliente</label><br>
                                    <input id="I23" style="margin-left: 20px" type="checkbox" name="clientesArchivar" value="1" @if($Permisos->clientesArchivar==1) checked @endif>-Archivar cliente</label><br>
                                    <input id="I24" style="margin-left: 20px" type="checkbox" name="clientesId" value="1" @if($Permisos->clientesId==1) checked @endif>-Ver ID</label><br>
                                    <input id="I25" style="margin-left: 20px" type="checkbox" name="clientesNombre" value="1" @if($Permisos->clientesNombre==1) checked @endif>-Ver Nombre</label><br>
                                    <input id="I26" style="margin-left: 20px" type="checkbox" name="clientesFechaRegistro" value="1" @if($Permisos->clientesFechaRegistro==1) checked @endif>-Ver fecha de registro</label><br>
                                    <input id="I27" style="margin-left: 20px" type="checkbox" name="clientesNumeroTelefono" value="1" @if($Permisos->clientesNumeroTelefono==1) checked @endif>-Ver numero de telefono</label><br>
                                    <input id="I28" style="margin-left: 20px" type="checkbox" name="clientesCorreoElectronico" value="1" @if($Permisos->clientesCorreoElectronico==1) checked @endif>-Ver correo electronico</label><br>
                                    
                            </div>
                            <div class="col-md-3">
                                    <label style="font-weight: bold"><input id="I29" style="font-weight: bold" type="checkbox" name="contratos" value="1" @if($Permisos->contratos==1) checked @endif>-Contratos</label><br>
                                    <input id="I30" style="margin-left: 20px" type="checkbox" name="contratosFolio" value="1" @if($Permisos->contratosFolio==1) checked @endif>-Ver Folio</label><br>
                                    <input id="I31" style="margin-left: 20px" type="checkbox" name="contratosFecha" value="1" @if($Permisos->contratosFecha==1) checked @endif>-Ver Fecha de Evento</label><br>
                                    <input id="I32" style="margin-left: 20px" type="checkbox" name="contratosCliente" value="1" @if($Permisos->contratosCliente==1) checked @endif>-Ver Cliente</label><br>
                                    <input id="I33" style="margin-left: 20px" type="checkbox" name="contratosVendedor" value="1" @if($Permisos->contratosVendedor==1) checked @endif>-Ver Vendedor</label><br>
                                    <input id="I34" style="margin-left: 20px" type="checkbox" name="contratosVersion" value="1" @if($Permisos->contratosVersion==1) checked @endif>-Ver Versión</label><br>
                                    <input id="I35" style="margin-left: 20px" type="checkbox" name="contratosImpresionCliente" value="1" @if($Permisos->contratosImpresionCliente==1) checked @endif>-Imprimir PDF cliente</label><br>
                                    <input id="I36" style="margin-left: 20px" type="checkbox" name="contratosEnviarCorreo" value="1" @if($Permisos->contratosEnviarCorreo==1) checked @endif>-Enviar Correo</label><br>
                                    <input id="I37" style="margin-left: 20px" type="checkbox" name="contratosImprimirBodega" value="1" @if($Permisos->contratosImprimirBodega==1) checked @endif>-Imprimir Ficha de Bodega</label><br>
                                    <input id="I38" style="margin-left: 20px" type="checkbox" name="contratosUltimaModificacion" value="1" @if($Permisos->contratosUltimaModificacion==1) checked @endif>-Ver Ultima Actualización</label><br>
                                    <input id="I39" style="margin-left: 20px" type="checkbox" name="contratosTotal" value="1" @if($Permisos->contratosTotal==1) checked @endif>-Ver Total</label><br>
                                    <input id="I40" style="margin-left: 20px" type="checkbox" name="contratosEditar" value="1" @if($Permisos->contratosEditar==1) checked @endif>-Editar Contrato</label><br>
                                    <input id="I41" style="margin-left: 20px" type="checkbox" name="contratosFichaTecnica" value="1" @if($Permisos->contratosFichaTecnica==1) checked @endif>-Ficha Tecnica</label><br>
                                    <input id="I42" style="margin-left: 20px" type="checkbox" name="contratosArchivar" value="1" @if($Permisos->contratosArchivar==1) checked @endif>-Cancelar Contrato</label><br>
                                    <input id="I43" style="margin-left: 20px" type="checkbox" name="contratosCrearContrato" value="1" @if($Permisos->contratosCrearContrato==1) checked @endif>-Crear Contrato</label><br>
                                    <input id="I44" style="margin-left: 20px" type="checkbox" name="contratosVistaCalendario" value="1" @if($Permisos->contratosVistaCalendario==1) checked @endif>-Vista Calendario</label><br>
                                    <input id="I45" style="margin-left: 20px" type="checkbox" name="contratosArchivados" value="1" @if($Permisos->contratosArchivados==1) checked @endif>-Contratos Archivados</label><br>
                                    <input id="I46" style="margin-left: 20px" type="checkbox" name="contratosHistorial" value="1" @if($Permisos->contratosHistorial==1) checked @endif>-Historial</label><br>
                                    <input id="" style="margin-left: 20px" type="checkbox" name="contratosFlete" value="1" checked>-Fletes</label><br>
                                
                            </div>
                            <div class="col-md-3">
                                    <label style="font-weight: bold"><input id="I47" style="font-weight: bold" type="checkbox" name="presupuestos" value="1" @if($Permisos->presupuestos==1) checked @endif>-Presupuestos</label><br>
                                    <input id="I48" style="margin-left: 20px" type="checkbox" name="presupuestosFolio" value="1" @if($Permisos->presupuestosFolio==1) checked @endif>-Ver Folio</label><br>
                                    <input id="I49" style="margin-left: 20px" type="checkbox" name="presupuestosFecha" value="1" @if($Permisos->presupuestosFecha==1) checked @endif>-Ver Fecha de Evento</label><br>
                                    <input id="I50" style="margin-left: 20px" type="checkbox" name="presupuestosCliente" value="1" @if($Permisos->presupuestosCliente==1) checked @endif>-Ver Cliente</label><br>
                                    <input id="I51" style="margin-left: 20px" type="checkbox" name="presupuestosVendedor" value="1" @if($Permisos->presupuestosVendedor==1) checked @endif>-Ver Vendedor</label><br>
                                    <input id="I52" style="margin-left: 20px" type="checkbox" name="presupuestosVersion" value="1" @if($Permisos->presupuestosVersion==1) checked @endif>-Ver Versión</label><br>
                                    <input id="I53" style="margin-left: 20px" type="checkbox" name="presupuestosImpresionCliente" value="1" @if($Permisos->presupuestosImpresionCliente==1) checked @endif>-Imprimir PDF cliente</label><br>
                                    <input id="I54" style="margin-left: 20px" type="checkbox" name="presupuestosEnviarCorreo" value="1" @if($Permisos->presupuestosEnviarCorreo==1) checked @endif>-Enviar Correo</label><br>
                                    <input id="I55" style="margin-left: 20px" type="checkbox" name="presupuestosImprimirBodega" value="1" @if($Permisos->presupuestosImprimirBodega==1) checked @endif>-Imprimir Ficha de Bodega</label><br>
                                    <input id="I56" style="margin-left: 20px" type="checkbox" name="presupuestosUltimaModificacion" value="1" @if($Permisos->presupuestosUltimaModificacion==1) checked @endif>-Ver Ultima Actualización</label><br>
                                    <input id="I57" style="margin-left: 20px" type="checkbox" name="presupuestosTotal" value="1" @if($Permisos->presupuestosTotal==1) checked @endif>-Ver Total</label><br>
                                    <input id="I58" style="margin-left: 20px" type="checkbox" name="presupuestosEditar" value="1" @if($Permisos->presupuestosEditar==1) checked @endif>-Editar Contrato</label><br>
                                    <input id="I59" style="margin-left: 20px" type="checkbox" name="presupuestosFichaTecnica" value="1" @if($Permisos->presupuestosFichaTecnica==1) checked @endif>-Ficha Tecnica</label><br>
                                    <input id="I60" style="margin-left: 20px" type="checkbox" name="presupuestosArchivar" value="1" @if($Permisos->presupuestosArchivar==1) checked @endif>-Cancelar Contrato</label><br>
                                    <input id="I61" style="margin-left: 20px" type="checkbox" name="presupuestosCrearContrato" value="1" @if($Permisos->presupuestosCrearContrato==1) checked @endif>-Crear Contrato</label><br>
                                    <input id="I62" style="margin-left: 20px" type="checkbox" name="presupuestosVistaCalendario" value="1" @if($Permisos->presupuestosVistaCalendario==1) checked @endif>-Vista Calendario</label><br>
                                    <input id="I63" style="margin-left: 20px" type="checkbox" name="presupuestosArchivados" value="1" @if($Permisos->presupuestosArchivados==1) checked @endif>-Contratos Archivados</label><br>
                                    <input id="I64" style="margin-left: 20px" type="checkbox" name="presupuestosHistorial" value="1" @if($Permisos->presupuestosHistorial==1) checked @endif>-Historial</label><br>
                            </div>
                                
                        </div>
                        <div class="row" style="padding-top: 20px; border-top:solid; border-width: 1px; margin-top: 20px">
                            <div class="col-md-3">
                                    <label style="font-weight: bold">-Creación de Presupuestos</label><br>
                                    <input id="I65" style="margin-left: 20px" type="checkbox" name="creacionEditarVendedor" value="1" @if($Permisos->creacionEditarVendedor==1) checked @endif>-Editar Vendedor</label><br>
                                    <input id="I66" style="margin-left: 20px" type="checkbox" name="creacionAdministrarCategorias" value="1" @if($Permisos->creacionAdministrarCategorias==1) checked @endif>-Administrar categorias</label><br>
                                    <input id="I67" style="margin-left: 20px" type="checkbox" name="creacionNuevoCliente" value="1" @if($Permisos->creacionNuevoCliente==1) checked @endif>-Nuevo Cliente</label><br>
                                    <input id="I68" style="margin-left: 20px" type="checkbox" name="creacionGuardarComoContrato" value="1" @if($Permisos->creacionGuardarComoContrato==1) checked @endif>-Guardar como contrato</label><br>
                                    <input id="I69" style="margin-left: 20px" type="checkbox" name="creacionSettings" value="1" @if($Permisos->creacionSettings==1) checked @endif>-Configuraciones</label><br>
                                    
                                    <label style="font-weight: bold"><input id="I" style="font-weight: bold" type="checkbox" name="comisiones" value="1" @if($Permisos->comisiones==1) checked @endif>-Comisiones</label><br>
                                    <input id="I70" style="margin-left: 20px" type="checkbox" name="comisionesImprimirReporte" value="1" @if($Permisos->comisionesImprimirReporte==1) checked @endif>-Ver Folio</label><br>
                                    <input id="I71" style="margin-left: 20px" type="checkbox" name="comisionesConfigurarComisiones" value="1" @if($Permisos->comisionesConfigurarComisiones==1) checked @endif>-Configurar Comisiones</label><br>
                                    
                                    <label style="font-weight: bold"><input id="I" style="font-weight: bold" type="checkbox" name="ventas" value="1" @if($Permisos->ventas==1) checked @endif>-ventas</label><br>
                                    <input id="I72" style="margin-left: 20px" type="checkbox" name="ventasImprimirReporte" value="1" @if($Permisos->ventasImprimirReporte==1) checked @endif>-Imprir Reporte</label><br>

                                    <label style="font-weight: bold"><input style="font-weight: bold" type="checkbox" name="usuarios" value="1" @if($Permisos->usuarios==1) checked @endif>-Usuarios</label><br>
                                    <input id="I73" style="margin-left: 20px" type="checkbox" name="usuariosEditar" value="1" @if($Permisos->usuariosEditar==1) checked @endif>-Editar Usuarios</label><br>
                                    <input id="I74" style="margin-left: 20px" type="checkbox" name="usuariosActivarDesactivar" value="1" @if($Permisos->usuariosActivarDesactivar==1) checked @endif>-Activar Desactivar</label><br>
                                    <input id="I75" style="margin-left: 20px" type="checkbox" name="usuariosPermisos" value="1" @if($Permisos->usuariosPermisos==1) checked @endif>-Editar Permisos</label><br>

                            </div>
                            <div class="col-md-3">
                                    <label style="font-weight: bold"><input id="I76" style="font-weight: bold" type="checkbox" name="inventarioInventario" value="1" @if($Permisos->inventarioInventario==1) checked @endif>-Opción inventario en menú</label><br>
                                    <input id="I77" style="margin-left: 20px" type="checkbox" name="inventarioFamilias" value="1" @if($Permisos->inventarioFamilias==1) checked @endif>-Opción familias en menu</label><br>
                                    <input id="I78" style="margin-left: 20px" type="checkbox" name="inventarioGrupos" value="1" @if($Permisos->inventarioGrupos==1) checked @endif>-Opción grupos en menu</label><br>
                                    <input id="I79" style="margin-left: 20px" type="checkbox" name="inventarioAgregarFamilia" value="1" @if($Permisos->inventarioAgregarFamilia==1) checked @endif>-Agregar Familia</label><br>
                                    <input id="I80" style="margin-left: 20px" type="checkbox" name="inventarioAgregarProducto" value="1" @if($Permisos->inventarioAgregarProducto==1) checked @endif>-Agregar Producto</label><br>
                                    <input id="I81" style="margin-left: 20px" type="checkbox" name="inventarioCrearPaquete" value="1" @if($Permisos->inventarioCrearPaquete==1) checked @endif>-Crear Paquete</label><br>
                                    <input id="I82" style="margin-left: 20px" type="checkbox" name="inventarioEditar" value="1" @if($Permisos->inventarioEditar==1) checked @endif>-Editar Producto</label><br>
                                    <input id="I83" style="margin-left: 20px" type="checkbox" name="inventarioArchivar" value="1" @if($Permisos->inventarioArchivar==1) checked @endif>-Archivar Producto</label><br>
                                    <input id="I84" style="margin-left: 20px" type="checkbox" name="inventarioAltasBajas" value="1" @if($Permisos->inventarioAltasBajas==1) checked @endif>-Altas y bajas de producto</label><br>
                                    <input id="I85" style="margin-left: 20px" type="checkbox" name="inventarioImprimirFamilia" value="1" @if($Permisos->inventarioImprimirFamilia==1) checked @endif>-Imprimir Familia</label><br>
                                    <input id="I86" style="margin-left: 20px" type="checkbox" name="inventarioTotalBodega" value="1" @if($Permisos->inventarioTotalBodega==1) checked @endif>-Ver total en bodega</label><br>
                                    <input id="I87" style="margin-left: 20px" type="checkbox" name="inventarioTotalExhibicion" value="1" @if($Permisos->inventarioTotalExhibicion==1) checked @endif>-Ver total en exhibición</label><br>
                                    <input id="I88" style="margin-left: 20px" type="checkbox" name="inventarioPrecioUnitario" value="1" @if($Permisos->inventarioPrecioUnitario==1) checked @endif>-Ver Precio Unitario</label><br>
                                    <input id="I89" style="margin-left: 20px" type="checkbox" name="inventarioProveedor" value="1" @if($Permisos->inventarioProveedor==1) checked @endif>-Ver Proveedor</label><br>
                                    <input id="I90" style="margin-left: 20px" type="checkbox" name="inventarioFamilia" value="1" @if($Permisos->inventarioFamilia==1) checked @endif>-Ver Familia</label><br>

                                   
                                    <input id="I91" style="margin-left: 20px" type="checkbox" name="inventarioPaquetes" value="1" @if($Permisos->inventarioPaquetes==1) checked @endif>-Ver Paquetes</label><br>
                                    <input id="I92" style="margin-left: 20px" type="checkbox" name="inventarioProximos" value="1" @if($Permisos->inventarioProximos==1) checked @endif>-Ver Proximos</label><br>
                                    <input id="I93" style="margin-left: 20px" type="checkbox" name="inventarioDanados" value="1" @if($Permisos->inventarioDanados==1) checked @endif>-Ver Dañados</label><br>
                                    <input id="I95" style="margin-left: 20px" type="checkbox" name="inventarioImpresionTransferencias" value="1" @if($Permisos->inventarioImpresionTransferencias==1) checked @endif>-Impresión reporte transferencias</label><br>
                            </div>
                            <div class="col-md-3">
                                    <input id="I94" style="margin-left: 20px" type="checkbox" name="Proveedores" value="1" @if($Permisos->Proveedores==1) checked @endif>-Ver Proveedores</label><br>
                                    
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
        function permisosGerencia(){
            document.getElementById('I2').checked=1;
            document.getElementById('I3').checked=1;
            document.getElementById('I4').checked=1;
            document.getElementById('I5').checked=1;
            document.getElementById('I6').checked=0;
            document.getElementById('I7').checked=1;
            document.getElementById('I8').checked=1;
            document.getElementById('I9').checked=1;
            document.getElementById('I10').checked=0;
            document.getElementById('I11').checked=0;
            document.getElementById('I12').checked=0;
            document.getElementById('I13').checked=0;
            document.getElementById('I14').checked=1;
            document.getElementById('I15').checked=1;
            document.getElementById('I16').checked=1;
            document.getElementById('I17').checked=1;
            document.getElementById('I18').checked=1;
            document.getElementById('I19').checked=1;
            document.getElementById('I20').checked=1;
            document.getElementById('I21').checked=1;
            document.getElementById('I22').checked=1;
            document.getElementById('I23').checked=1;
            document.getElementById('I24').checked=1;
            document.getElementById('I25').checked=1;
            document.getElementById('I26').checked=1;
            document.getElementById('I27').checked=1;
            document.getElementById('I28').checked=1;
            document.getElementById('I29').checked=1;
            document.getElementById('I30').checked=1;
            document.getElementById('I31').checked=1;
            document.getElementById('I32').checked=1;
            document.getElementById('I33').checked=1;
            document.getElementById('I34').checked=1;
            document.getElementById('I35').checked=1;
            document.getElementById('I36').checked=1;
            document.getElementById('I37').checked=0;
            document.getElementById('I38').checked=1;
            document.getElementById('I39').checked=1;
            document.getElementById('I40').checked=1;
            document.getElementById('I41').checked=1;
            document.getElementById('I42').checked=1;
            document.getElementById('I43').checked=1;
            document.getElementById('I44').checked=1;
            document.getElementById('I45').checked=1;
            document.getElementById('I46').checked=1;
            document.getElementById('I47').checked=1;
            document.getElementById('I48').checked=1;
            document.getElementById('I49').checked=1;
            document.getElementById('I50').checked=1;
            document.getElementById('I51').checked=1;
            document.getElementById('I52').checked=1;
            document.getElementById('I53').checked=1;
            document.getElementById('I54').checked=1;
            document.getElementById('I55').checked=0;
            document.getElementById('I56').checked=1;
            document.getElementById('I57').checked=1;
            document.getElementById('I58').checked=1;
            document.getElementById('I59').checked=1;
            document.getElementById('I60').checked=1;
            document.getElementById('I61').checked=1;
            document.getElementById('I62').checked=1;
            document.getElementById('I63').checked=1;
            document.getElementById('I64').checked=1;
            document.getElementById('I65').checked=1;
            document.getElementById('I66').checked=1;
            document.getElementById('I67').checked=1;
            document.getElementById('I68').checked=1;
            document.getElementById('I69').checked=0;
            document.getElementById('I70').checked=0;
            document.getElementById('I71').checked=0;
            document.getElementById('I72').checked=0;
            document.getElementById('I73').checked=0;
            document.getElementById('I74').checked=0;
            document.getElementById('I75').checked=0;
            document.getElementById('I76').checked=1;
            document.getElementById('I77').checked=0;
            document.getElementById('I78').checked=0;
            document.getElementById('I79').checked=0;
            document.getElementById('I80').checked=0;
            document.getElementById('I81').checked=0;
            document.getElementById('I82').checked=0;
            document.getElementById('I83').checked=0;
            document.getElementById('I84').checked=0;
            document.getElementById('I85').checked=0;
            document.getElementById('I86').checked=1;
            document.getElementById('I87').checked=1;
            document.getElementById('I88').checked=1;
            document.getElementById('I89').checked=1;
            document.getElementById('I90').checked=1;
        }
        function permisosVentas(){
            document.getElementById('I2').checked=1;
            document.getElementById('I3').checked=1;
            document.getElementById('I4').checked=1;
            document.getElementById('I5').checked=0;
            document.getElementById('I6').checked=0;
            document.getElementById('I7').checked=1;
            document.getElementById('I8').checked=1;
            document.getElementById('I9').checked=1;
            document.getElementById('I10').checked=0;
            document.getElementById('I11').checked=0;
            document.getElementById('I12').checked=0;
            document.getElementById('I13').checked=0;
            document.getElementById('I14').checked=1;
            document.getElementById('I15').checked=1;
            document.getElementById('I16').checked=1;
            document.getElementById('I17').checked=1;
            document.getElementById('I18').checked=1;
            document.getElementById('I19').checked=1;
            document.getElementById('I20').checked=1;
            document.getElementById('I21').checked=1;
            document.getElementById('I22').checked=1;
            document.getElementById('I23').checked=1;
            document.getElementById('I24').checked=1;
            document.getElementById('I25').checked=1;
            document.getElementById('I26').checked=1;
            document.getElementById('I27').checked=1;
            document.getElementById('I28').checked=1;
            document.getElementById('I29').checked=1;
            document.getElementById('I30').checked=1;
            document.getElementById('I31').checked=1;
            document.getElementById('I32').checked=1;
            document.getElementById('I33').checked=1;
            document.getElementById('I34').checked=1;
            document.getElementById('I35').checked=1;
            document.getElementById('I36').checked=1;
            document.getElementById('I37').checked=0;
            document.getElementById('I38').checked=1;
            document.getElementById('I39').checked=1;
            document.getElementById('I40').checked=1;
            document.getElementById('I41').checked=1;
            document.getElementById('I42').checked=1;
            document.getElementById('I43').checked=1;
            document.getElementById('I44').checked=1;
            document.getElementById('I45').checked=1;
            document.getElementById('I46').checked=1;
            document.getElementById('I47').checked=1;
            document.getElementById('I48').checked=1;
            document.getElementById('I49').checked=1;
            document.getElementById('I50').checked=1;
            document.getElementById('I51').checked=1;
            document.getElementById('I52').checked=1;
            document.getElementById('I53').checked=1;
            document.getElementById('I54').checked=1;
            document.getElementById('I55').checked=0;
            document.getElementById('I56').checked=1;
            document.getElementById('I57').checked=1;
            document.getElementById('I58').checked=1;
            document.getElementById('I59').checked=1;
            document.getElementById('I60').checked=1;
            document.getElementById('I61').checked=1;
            document.getElementById('I62').checked=1;
            document.getElementById('I63').checked=1;
            document.getElementById('I64').checked=1;
            document.getElementById('I65').checked=1;
            document.getElementById('I66').checked=1;
            document.getElementById('I67').checked=1;
            document.getElementById('I68').checked=1;
            document.getElementById('I69').checked=0;
            document.getElementById('I70').checked=0;
            document.getElementById('I71').checked=0;
            document.getElementById('I72').checked=0;
            document.getElementById('I73').checked=0;
            document.getElementById('I74').checked=0;
            document.getElementById('I75').checked=0;
            document.getElementById('I76').checked=1;
            document.getElementById('I77').checked=0;
            document.getElementById('I78').checked=0;
            document.getElementById('I79').checked=0;
            document.getElementById('I80').checked=0;
            document.getElementById('I81').checked=0;
            document.getElementById('I82').checked=0;
            document.getElementById('I83').checked=0;
            document.getElementById('I84').checked=0;
            document.getElementById('I85').checked=0;
            document.getElementById('I86').checked=1;
            document.getElementById('I87').checked=1;
            document.getElementById('I88').checked=1;
            document.getElementById('I89').checked=0;
            document.getElementById('I90').checked=1;
        }
        function permisosRecepcionista(){
            document.getElementById('I2').checked=1;
            document.getElementById('I3').checked=1;
            document.getElementById('I4').checked=1;
            document.getElementById('I5').checked=0;
            document.getElementById('I6').checked=0;
            document.getElementById('I7').checked=1;
            document.getElementById('I8').checked=1;
            document.getElementById('I9').checked=1;
            document.getElementById('I10').checked=0;
            document.getElementById('I11').checked=0;
            document.getElementById('I12').checked=0;
            document.getElementById('I13').checked=0;
            document.getElementById('I14').checked=1;
            document.getElementById('I15').checked=1;
            document.getElementById('I16').checked=0;
            document.getElementById('I17').checked=0;
            document.getElementById('I18').checked=1;
            document.getElementById('I19').checked=1;
            document.getElementById('I20').checked=1;
            document.getElementById('I21').checked=1;
            document.getElementById('I22').checked=1;
            document.getElementById('I23').checked=1;
            document.getElementById('I24').checked=1;
            document.getElementById('I25').checked=1;
            document.getElementById('I26').checked=1;
            document.getElementById('I27').checked=1;
            document.getElementById('I28').checked=1;
            document.getElementById('I29').checked=1;
            document.getElementById('I30').checked=1;
            document.getElementById('I31').checked=1;
            document.getElementById('I32').checked=1;
            document.getElementById('I33').checked=1;
            document.getElementById('I34').checked=1;
            document.getElementById('I35').checked=1;
            document.getElementById('I36').checked=1;
            document.getElementById('I37').checked=0;
            document.getElementById('I38').checked=1;
            document.getElementById('I39').checked=1;
            document.getElementById('I40').checked=1;
            document.getElementById('I41').checked=1;
            document.getElementById('I42').checked=1;
            document.getElementById('I43').checked=1;
            document.getElementById('I44').checked=1;
            document.getElementById('I45').checked=1;
            document.getElementById('I46').checked=1;
            document.getElementById('I47').checked=1;
            document.getElementById('I48').checked=1;
            document.getElementById('I49').checked=1;
            document.getElementById('I50').checked=1;
            document.getElementById('I51').checked=1;
            document.getElementById('I52').checked=1;
            document.getElementById('I53').checked=1;
            document.getElementById('I54').checked=1;
            document.getElementById('I55').checked=0;
            document.getElementById('I56').checked=1;
            document.getElementById('I57').checked=1;
            document.getElementById('I58').checked=1;
            document.getElementById('I59').checked=1;
            document.getElementById('I60').checked=1;
            document.getElementById('I61').checked=1;
            document.getElementById('I62').checked=1;
            document.getElementById('I63').checked=1;
            document.getElementById('I64').checked=1;
            document.getElementById('I65').checked=1;
            document.getElementById('I66').checked=1;
            document.getElementById('I67').checked=1;
            document.getElementById('I68').checked=1;
            document.getElementById('I69').checked=0;
            document.getElementById('I70').checked=0;
            document.getElementById('I71').checked=0;
            document.getElementById('I72').checked=0;
            document.getElementById('I73').checked=0;
            document.getElementById('I74').checked=0;
            document.getElementById('I75').checked=0;
            document.getElementById('I76').checked=1;
            document.getElementById('I77').checked=0;
            document.getElementById('I78').checked=0;
            document.getElementById('I79').checked=0;
            document.getElementById('I80').checked=0;
            document.getElementById('I81').checked=0;
            document.getElementById('I82').checked=0;
            document.getElementById('I83').checked=0;
            document.getElementById('I84').checked=0;
            document.getElementById('I85').checked=0;
            document.getElementById('I86').checked=1;
            document.getElementById('I87').checked=1;
            document.getElementById('I88').checked=1;
            document.getElementById('I89').checked=0;
            document.getElementById('I90').checked=1;
        }
        function permisosBodega(){
            document.getElementById('I2').checked=1;
            document.getElementById('I3').checked=0;
            document.getElementById('I4').checked=0;
            document.getElementById('I5').checked=0;
            document.getElementById('I6').checked=0;
            document.getElementById('I7').checked=1;
            document.getElementById('I8').checked=1;
            document.getElementById('I9').checked=1;
            document.getElementById('I10').checked=0;
            document.getElementById('I11').checked=0;
            document.getElementById('I12').checked=0;
            document.getElementById('I13').checked=0;
            document.getElementById('I14').checked=0;
            document.getElementById('I15').checked=0;
            document.getElementById('I16').checked=0;
            document.getElementById('I17').checked=0;
            document.getElementById('I18').checked=0;
            document.getElementById('I19').checked=0;
            document.getElementById('I20').checked=0;
            document.getElementById('I21').checked=0;
            document.getElementById('I22').checked=0;
            document.getElementById('I23').checked=0;
            document.getElementById('I24').checked=0;
            document.getElementById('I25').checked=0;
            document.getElementById('I26').checked=0;
            document.getElementById('I27').checked=0;
            document.getElementById('I28').checked=0;
            document.getElementById('I29').checked=1;
            document.getElementById('I30').checked=1;
            document.getElementById('I31').checked=1;
            document.getElementById('I32').checked=1;
            document.getElementById('I33').checked=1;
            document.getElementById('I34').checked=1;
            document.getElementById('I35').checked=0;
            document.getElementById('I36').checked=0;
            document.getElementById('I37').checked=1;
            document.getElementById('I38').checked=1;
            document.getElementById('I39').checked=0;
            document.getElementById('I40').checked=0;
            document.getElementById('I41').checked=1;
            document.getElementById('I42').checked=0;
            document.getElementById('I43').checked=0;
            document.getElementById('I44').checked=0;
            document.getElementById('I45').checked=0;
            document.getElementById('I46').checked=0;
            document.getElementById('I47').checked=0;
            document.getElementById('I48').checked=0;
            document.getElementById('I49').checked=0;
            document.getElementById('I50').checked=0;
            document.getElementById('I51').checked=0;
            document.getElementById('I52').checked=0;
            document.getElementById('I53').checked=0;
            document.getElementById('I54').checked=0;
            document.getElementById('I55').checked=0;
            document.getElementById('I56').checked=0;
            document.getElementById('I57').checked=0;
            document.getElementById('I58').checked=0;
            document.getElementById('I59').checked=0;
            document.getElementById('I60').checked=0;
            document.getElementById('I61').checked=0;
            document.getElementById('I62').checked=0;
            document.getElementById('I63').checked=0;
            document.getElementById('I64').checked=0;
            document.getElementById('I65').checked=0;
            document.getElementById('I66').checked=0;
            document.getElementById('I67').checked=0;
            document.getElementById('I68').checked=0;
            document.getElementById('I69').checked=0;
            document.getElementById('I70').checked=0;
            document.getElementById('I71').checked=0;
            document.getElementById('I72').checked=0;
            document.getElementById('I73').checked=0;
            document.getElementById('I74').checked=0;
            document.getElementById('I75').checked=0;
            document.getElementById('I76').checked=1;
            document.getElementById('I77').checked=0;
            document.getElementById('I78').checked=0;
            document.getElementById('I79').checked=0;
            document.getElementById('I80').checked=0;
            document.getElementById('I81').checked=0;
            document.getElementById('I82').checked=0;
            document.getElementById('I83').checked=0;
            document.getElementById('I84').checked=0;
            document.getElementById('I85').checked=0;
            document.getElementById('I86').checked=1;
            document.getElementById('I87').checked=1;
            document.getElementById('I88').checked=0;
            document.getElementById('I89').checked=0;
            document.getElementById('I90').checked=1;
        }
        function permisosContabilidad(){}
        function permisosAdministrador(){
            document.getElementById('I2').checked=1;
            document.getElementById('I3').checked=1;
            document.getElementById('I4').checked=1;
            document.getElementById('I5').checked=1;
            document.getElementById('I6').checked=1;
            document.getElementById('I7').checked=1;
            document.getElementById('I8').checked=1;
            document.getElementById('I9').checked=1;
            document.getElementById('I10').checked=1;
            document.getElementById('I11').checked=1;
            document.getElementById('I12').checked=1;
            document.getElementById('I13').checked=1;
            document.getElementById('I14').checked=1;
            document.getElementById('I15').checked=1;
            document.getElementById('I16').checked=1;
            document.getElementById('I17').checked=1;
            document.getElementById('I18').checked=1;
            document.getElementById('I19').checked=1;
            document.getElementById('I20').checked=1;
            document.getElementById('I21').checked=1;
            document.getElementById('I22').checked=1;
            document.getElementById('I23').checked=1;
            document.getElementById('I24').checked=1;
            document.getElementById('I25').checked=1;
            document.getElementById('I26').checked=1;
            document.getElementById('I27').checked=1;
            document.getElementById('I28').checked=1;
            document.getElementById('I29').checked=1;
            document.getElementById('I30').checked=1;
            document.getElementById('I31').checked=1;
            document.getElementById('I32').checked=1;
            document.getElementById('I33').checked=1;
            document.getElementById('I34').checked=1;
            document.getElementById('I35').checked=1;
            document.getElementById('I36').checked=1;
            document.getElementById('I37').checked=1;
            document.getElementById('I38').checked=1;
            document.getElementById('I39').checked=1;
            document.getElementById('I40').checked=1;
            document.getElementById('I41').checked=1;
            document.getElementById('I42').checked=1;
            document.getElementById('I43').checked=1;
            document.getElementById('I44').checked=1;
            document.getElementById('I45').checked=1;
            document.getElementById('I46').checked=1;
            document.getElementById('I47').checked=1;
            document.getElementById('I48').checked=1;
            document.getElementById('I49').checked=1;
            document.getElementById('I50').checked=1;
            document.getElementById('I51').checked=1;
            document.getElementById('I52').checked=1;
            document.getElementById('I53').checked=1;
            document.getElementById('I54').checked=1;
            document.getElementById('I55').checked=1;
            document.getElementById('I56').checked=1;
            document.getElementById('I57').checked=1;
            document.getElementById('I58').checked=1;
            document.getElementById('I59').checked=1;
            document.getElementById('I60').checked=1;
            document.getElementById('I61').checked=1;
            document.getElementById('I62').checked=1;
            document.getElementById('I63').checked=1;
            document.getElementById('I64').checked=1;
            document.getElementById('I65').checked=1;
            document.getElementById('I66').checked=1;
            document.getElementById('I67').checked=1;
            document.getElementById('I68').checked=1;
            document.getElementById('I69').checked=1;
            document.getElementById('I70').checked=1;
            document.getElementById('I71').checked=1;
            document.getElementById('I72').checked=1;
            document.getElementById('I73').checked=1;
            document.getElementById('I74').checked=1;
            document.getElementById('I75').checked=1;
            document.getElementById('I76').checked=1;
            document.getElementById('I77').checked=1;
            document.getElementById('I78').checked=1;
            document.getElementById('I79').checked=1;
            document.getElementById('I80').checked=1;
            document.getElementById('I81').checked=1;
            document.getElementById('I82').checked=1;
            document.getElementById('I83').checked=1;
            document.getElementById('I84').checked=1;
            document.getElementById('I85').checked=1;
            document.getElementById('I86').checked=1;
            document.getElementById('I87').checked=1;
            document.getElementById('I88').checked=1;
            document.getElementById('I89').checked=1;
            document.getElementById('I90').checked=1;
        }

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

