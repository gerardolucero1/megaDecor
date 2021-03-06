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
            $table->integer('client_id')->unsigned();
            $table->integer('about_id');
            $table->string('nombre');
            $table->string('apellidoPaterno');
            $table->string('apellidoMaterno');
            $table->string('email');
            $table->string('telefono');
            $table->string('direccionEmpresa');
            $table->string('coloniaEmpresa');
            $table->string('numeroEmpresa');

            //Datos de Facturacion

            $table->string('nombreFacturacion')->nullable();
            $table->string('direccionFacturacion')->nullable();
            $table->string('coloniaFacturacion')->nullable();
            $table->string('numeroFacturacion')->nullable();
            $table->string('rfcFacturacion')->nullable();
            $table->string('emailFacturacion')->nullable();

            //Credito
            $table->enum('tipoCredito', ['SIN CREDITO', 'ORDINARIO', 'LABORAL']);
            $table->integer('diasCredito')->nullable();
            
            $table->timestamps();

            //Relations
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
        Schema::dropIfExists('physical_people');
    }
}
