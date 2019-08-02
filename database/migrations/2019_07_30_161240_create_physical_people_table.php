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
            $table->integer('cliente_id')->unsigned();
            $table->integer('about_id')->unsigned();
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

            //Credito
            $table->enum('tipoCredito', ['SIN CREDITO', 'ORDINARIO', 'LABORAL']);
            
            $table->timestamps();

            //Relations
            $table->foreign('cliente_id')->references('id')->on('clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->foreign('about_id')->references('id')->on('about_categories')
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
        Schema::dropIfExists('physical_people');
    }
}
