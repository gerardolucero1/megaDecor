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
            $table->integer('vendedor_id')->unsigned();
            $table->integer('cliente_id')->unsigned();

            $table->string('tipoEvento');
            $table->string('tipoServicio')->nullable();
            $table->string('categoriaEvento');
            $table->date('fechaEvento');
            $table->boolean('pendienteFecha');
            $table->time('horaEventoInicio');
            $table->time('horaEventoFin');
            $table->boolean('pendienteHora');

            //Lugar del evento
            $table->enum('lugarEvento', ['MISMA', 'OTRA']);
            $table->boolean('pendienteLugar');
            $table->string('nombreLugar');
            $table->string('direccionLugar');
            $table->string('numeroLugar');
            $table->string('coloniaLugar');
            $table->string('CPLugar');
            $table->mediumText('observacionesLugar');

            //Informacion del evento
            $table->integer('numeroInvitados');
            $table->string('colorEvento');
            $table->string('temaEvento');

            $table->timestamps();

            //Relations
            $table->foreign('vendedor_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('cliente_id')->references('id')->on('clients')
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
