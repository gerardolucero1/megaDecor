<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaltantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faltantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contrato');
            $table->string('fecha');
            $table->string('nombre_de_persona');
            $table->string('descripcion');
            $table->string('cantidad_que_falta');
            $table->string('dias_desde_no_regreso');
            $table->string('id_article');
            $table->timestamps();
        });
    }
/*
        'contrato',
        'fecha',
        'nombre_de_persona',
        'descripcion',
        'cantidad_que_falta',
        'dias_desde_no_regreso',

*/
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faltantes');
    }
}
