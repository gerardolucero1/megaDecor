<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('porcentajeCrecimientoVentas');
            $table->integer('porcentajeCrecimientoUtilidad');
            $table->integer('bonoObjetivoVentas');
            $table->integer('bonoObjetivoNoVentas');
            $table->integer('comisionContrato');
            $table->integer('bonoVendedorMes');
            $table->integer('minimoVentaComision');
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
        Schema::dropIfExists('commissions');
    }
}
