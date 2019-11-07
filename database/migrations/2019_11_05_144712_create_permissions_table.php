<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('dashboard')->nullable();
            $table->boolean('dashboardCrearPresupuesto')->nullable();
            $table->boolean('dashboardNuevoCliente')->nullable();
            $table->boolean('dashboardReporteVentas')->nullable();
            $table->boolean('dashboardConfiguraciones')->nullable();
            $table->boolean('dashboardAperturaCaja')->nullable();
            $table->boolean('dashboardPresupuestosActivos')->nullable();
            $table->boolean('dashboardContratosHoy')->nullable();
            $table->boolean('dashboardElementosDanados')->nullable();
            $table->boolean('dashboardCreditosAtrasados')->nullable();
            $table->boolean('dashboardComponenteVentas')->nullable();
            $table->boolean('dashboardComponenteContabilidad')->nullable();
            $table->boolean('dashboardListaTareas')->nullable();
            $table->boolean('dashboardCalendario')->nullable();
            $table->boolean('dashboardVendedorMes')->nullable();
            $table->boolean('dashboardVentasMes')->nullable();
            $table->boolean('clientes')->nullable();
            $table->boolean('clientesNuevoCliente')->nullable();
            $table->boolean('clientesArchivados')->nullable();
            $table->boolean('clientesEditar')->nullable();
            $table->boolean('clientesArchivar')->nullable();
            $table->boolean('clientesId')->nullable();
            $table->boolean('clientesNombre')->nullable();
            $table->boolean('clientesFechaRegistro')->nullable();
            $table->boolean('clientesNumeroTelefono')->nullable();
            $table->boolean('clientesCorreoElectronico')->nullable();
            $table->boolean('contratos')->nullable();
            $table->boolean('contratosFolio')->nullable();
            $table->boolean('contratosFecha')->nullable();
            $table->boolean('contratosCliente')->nullable();
            $table->boolean('contratosVendedor')->nullable();
            $table->boolean('contratosVersion')->nullable();
            $table->boolean('contratosImpresionCliente')->nullable();
            $table->boolean('contratosEnviarCorreo')->nullable();
            $table->boolean('contratosImprimirBodega')->nullable();
            $table->boolean('contratosUltimaModificacion')->nullable();
            $table->boolean('contratosTotal')->nullable();
            $table->boolean('contratosEditar')->nullable();
            $table->boolean('contratosFichaTecnica')->nullable();
            $table->boolean('contratosArchivar')->nullable();
            $table->boolean('contratosCrearContrato')->nullable();
            $table->boolean('contratosVistaCalendario')->nullable();
            $table->boolean('contratosArchivados')->nullable();
            $table->boolean('contratosHistorial')->nullable();
            $table->boolean('presupuestos')->nullable();
            $table->boolean('presupuestosFolio')->nullable();
            $table->boolean('presupuestosFecha')->nullable();
            $table->boolean('presupuestosCliente')->nullable();
            $table->boolean('presupuestosVendedor')->nullable();
            $table->boolean('presupuestosVersion')->nullable();
            $table->boolean('presupuestosImpresionCliente')->nullable();
            $table->boolean('presupuestosEnviarCorreo')->nullable();
            $table->boolean('presupuestosImprimirBodega')->nullable();
            $table->boolean('presupuestosUltimaModificacion')->nullable();
            $table->boolean('presupuestosTotal')->nullable();
            $table->boolean('presupuestosEditar')->nullable();
            $table->boolean('presupuestosFichaTecnica')->nullable();
            $table->boolean('presupuestosArchivar')->nullable();
            $table->boolean('presupuestosCrearContrato')->nullable();
            $table->boolean('presupuestosVistaCalendario')->nullable();
            $table->boolean('presupuestosArchivados')->nullable();
            $table->boolean('presupuestosHistorial')->nullable();
            $table->boolean('creacionEditarVendedor')->nullable();
            $table->boolean('creacionAdministrarCategorias')->nullable();
            $table->boolean('creacionNuevoCliente')->nullable();
            $table->boolean('creacionGuardarComoContrato')->nullable();
            $table->boolean('creacionSettings')->nullable();
            $table->boolean('comisiones')->nullable();
            $table->boolean('comisionesImprimirReporte')->nullable();
            $table->boolean('comisionesConfigurarComisiones')->nullable();
            $table->boolean('ventas')->nullable();
            $table->boolean('ventasImprimirReporte')->nullable();
            $table->boolean('inventarioInventario')->nullable();
            $table->boolean('inventarioFamilias')->nullable();
            $table->boolean('inventarioGrupos')->nullable();
            $table->boolean('inventarioAgregarFamilia')->nullable();
            $table->boolean('inventarioAgregarProducto')->nullable();
            $table->boolean('inventarioCrearPaquete')->nullable();
            $table->boolean('inventarioEditar')->nullable();
            $table->boolean('inventarioArchivar')->nullable();
            $table->boolean('inventarioAltasBajas')->nullable();
            $table->boolean('inventarioImprimirFamilia')->nullable();
            $table->boolean('inventarioTotalBodega')->nullable();
            $table->boolean('inventarioTotalExhibicion')->nullable();
            $table->boolean('inventarioPrecioUnitario')->nullable();
            $table->boolean('inventarioProveedor')->nullable();
            $table->boolean('inventarioFamilia')->nullable();
            $table->boolean('usuarios')->nullable();
            $table->boolean('usuariosEditar')->nullable();
            $table->boolean('usuariosActivarDesactivar')->nullable();
            $table->boolean('usuariosPermisos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
