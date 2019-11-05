<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizedPackInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorized_pack_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_pack_id')->unsigned();
            $table->string('servicio');
            $table->string('imagen');
            $table->integer('cantidad');
            $table->integer('precioUnitario');
            $table->integer('precioFinal');
            $table->integer('precioVenta')->nullable();
            $table->integer('precioEspecial')->nullable();
            $table->integer('precioAnterior')->nullable();
            $table->string('proveedor')->nullable();
            $table->boolean('externo');
            $table->timestamps();

            //Relations
            $table->foreign('budget_pack_id')->references('id')->on('authorized_packs')
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
        Schema::dropIfExists('authorized_pack_inventories');
    }
}
