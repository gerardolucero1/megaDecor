<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhysicalPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellidoPaterno');
            $table->string('apellidoMaterno');
            $table->string('email');

            //Datos de Facturacion

            $table->string('nombreFacturacion');
            $table->string('direccionFacturacion');
            $table->string('coloniaFacturacion');
            $table->string('numeroFacturacion');
            $table->string('rfcFacturacion');
            $table->string('emailFacturacion');
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
        Schema::dropIfExists('physical_people');
    }
}
