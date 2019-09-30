<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_id')->unsigned();
            $table->string('servicio');
            $table->string('imagen');
            $table->float('precioUnitario');
            $table->float('precioVenta')->nullable();
            $table->string('proveedor')->nullable();
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
        Schema::dropIfExists('external_inventories');
    }
}
