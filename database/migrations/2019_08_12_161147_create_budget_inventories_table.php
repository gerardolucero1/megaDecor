<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_id')->unsigned();
            $table->string('servicio');
            $table->string('imagen');
            $table->integer('cantidad');
            $table->integer('precioUnitario');
            $table->integer('precioFinal');
            $table->integer('precioVenta')->nullable();
            $table->integer('ahorro');
            $table->string('notas');
            $table->boolean('externo');
            $table->string('proveedor')->nullable();
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
        Schema::dropIfExists('budget_inventories');
    }
}
