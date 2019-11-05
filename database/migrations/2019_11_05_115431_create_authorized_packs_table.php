<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizedPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorized_packs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_id')->nullable();
            $table->string('servicio');
            $table->integer('cantidad');
            $table->integer('precioUnitario');
            $table->integer('precioFinal');
            $table->integer('precioVenta');
            $table->integer('precioEspecial');
            $table->integer('precioAnterior');
            $table->integer('ahorro');
            $table->string('notas');
            $table->string('categoria');
            $table->boolean('guardarPaquete');
            $table->integer('version')->nullable();
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
        Schema::dropIfExists('authorized_packs');
    }
}
