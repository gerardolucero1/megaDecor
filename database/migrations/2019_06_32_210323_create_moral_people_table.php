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
            $table->integer('cliente_id')->unsigned();
            $table->integer('categoria_id')->unsigned();
            $table->integer('about_id')->unsigned();
            $table->string('nombre');
            
            //Datos de Facturacion

            $table->string('nombreFacturacion');
            $table->string('direccionFacturacion');
            $table->string('coloniaFacturacion');
            $table->string('numeroFacturacion');
            $table->string('rfcFacturacion');
            $table->string('emailFacturacion');
            $table->timestamps();

            //Relations
            $table->foreign('cliente_id')->references('id')->on('clients')
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
