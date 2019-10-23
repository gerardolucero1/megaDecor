<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('folio');
            
            //Presupuesto o contrato
            $table->enum('tipo', ['PRESUPUESTO', 'CONTRATO']);

            $table->integer('vendedor_id')->unsigned();
            $table->integer('client_id')->unsigned();

            $table->string('tipoEvento');
            $table->string('tipoServicio')->nullable();
            $table->string('categoriaEvento');
            $table->date('fechaEvento')->nullable();
            $table->boolean('pendienteFecha')->nullable();
            $table->time('horaEventoInicio')->nullable();
            $table->time('horaEventoFin')->nullable();
            $table->boolean('pendienteHora')->nullable();

            //Lugar del evento
            $table->enum('lugarEvento', ['MISMA', 'OTRA'])->nullable();
            $table->boolean('pendienteLugar')->nullable();
            $table->string('nombreLugar')->nullable();
            $table->string('direccionLugar')->nullable();
            $table->string('numeroLugar')->nullable();
            $table->string('coloniaLugar')->nullable();
            $table->string('CPLugar')->nullable();
            $table->mediumText('observacionesLugar')->nullable();

            //Informacion del evento
            $table->integer('numeroInvitados');
            $table->string('colorEvento');
            $table->string('temaEvento');

            //Opciones presupuesto
            $table->boolean('opcionPrecio')->nullable();
            $table->boolean('opcionPrecioUnitario')->nullable();
            $table->boolean('opcionDescripcionPaquete')->nullable();
            $table->boolean('opcionImagen')->nullable();
            $table->boolean('opcionDescuento')->nullable();
            $table->boolean('opcionIVA')->nullable();

            //Datos de facturacion
            $table->time('horaInicio')->nullable();
            $table->time('horaFin')->nullable();
            $table->string('horaEntrega')->nullable();
            $table->date('fechaRecoleccion')->nullable();
            $table->time('horaRecoleccion')->nullable();
            $table->string('recoleccionPreferente')->nullable();
            $table->string('notasFacturacion')->nullable();
            $table->string('nombreFacturacion')->nullable();
            $table->string('direccionFacturacion')->nullable();
            $table->string('numeroFacturacion')->nullable();
            $table->string('coloniaFacturacion')->nullable();
            $table->string('emailFacturacion')->nullable();
            $table->string('rfcFacturacion')->nullable();

            //Impresion
            $table->boolean('impresion')->nullable();

            //Pagado
            $table->boolean('pagado')->nullable();

            //Version
            $table->integer('version')->nullable();
            $table->double('comision')->nullable();
            $table->double('total')->nullable();

            //archivar
            $table->boolean('archivado')->default(0)->nullable();

            // Notas
            $table->text('notasPresupuesto')->nullable();

            $table->string('requiereFactura')->nullable();
            $table->string('requiereMontaje')->nullable();

            $table->timestamps();

            //Relations
            $table->foreign('vendedor_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('client_id')->references('id')->on('clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budgets');
    }
}
