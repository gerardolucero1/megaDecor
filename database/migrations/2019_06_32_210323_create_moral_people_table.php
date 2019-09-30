<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoralPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moral_people', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('categoria_id')->unsigned();
            $table->integer('about_id')->unsigned();
            $table->string('nombre');
            $table->string('email');
            $table->string('direccionEmpresa');
            $table->string('coloniaEmpresa');
            $table->string('numeroEmpresa');
            $table->string('telefono');
            
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
            
            $table->foreign('categoria_id')->references('id')->on('moral_categories')
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
        Schema::dropIfExists('moral_people');
    }
}
