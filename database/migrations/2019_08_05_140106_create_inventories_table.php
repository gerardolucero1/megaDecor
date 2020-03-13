<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->integer('disponible')->nullable();
            $table->string('servicio');
            $table->string('imagen')->nullable();
            $table->integer('precioUnitario');
            $table->boolean('autorizado')->nullable();
            $table->double('precioVenta')->nullable();
            $table->string('tipoCambio')->nullable();
            $table->string('proveedor1')->nullable();
            $table->string('proveedor2')->nullable();
            $table->integer('exhibicion')->nullable();
            $table->string('familia')->nullable();
            $table->string('selectmoneda')->nullable();
            $table->string('factura')->nullable();
            $table->date('fechaCompra')->nullable();
            $table->boolean('noAplica')->nullable();
            $table->boolean('guardarInventario')->nullable();
            $table->boolean('anidado')->nullable();
            
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
        Schema::dropIfExists('inventories');
    }
}
