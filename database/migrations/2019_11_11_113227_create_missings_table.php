<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('inventory_id')->unsigned()->nullable();
            $table->string('servicio')->nullable();
            $table->integer('saliente')->nullable();
            $table->integer('faltante')->nullable();
            $table->boolean('reportado')->nullable();
            $table->boolean('aprobado')->nullable();
            $table->integer('total')->nullable();
            $table->timestamps();

            //Relation
            $table->foreign('inventory_id')->references('id')->on('inventories')
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
        Schema::dropIfExists('missings');
    }
}
