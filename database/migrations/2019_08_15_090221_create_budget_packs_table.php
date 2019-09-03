<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_packs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_id')->unsigned();
            $table->string('servicio');
            $table->integer('cantidad');
            $table->integer('precioUnitario');
            $table->integer('precioFinal');
            $table->integer('ahorro');
            $table->string('notas');
            $table->string('categoria');
            $table->boolean('guardarPaquete');
            $table->integer('version')->nullable();
            $table->timestamps();

            //Relations
            $table->foreign('budget_id')->references('id')->on('budgets')
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
        Schema::dropIfExists('budget_packs');
    }
}
