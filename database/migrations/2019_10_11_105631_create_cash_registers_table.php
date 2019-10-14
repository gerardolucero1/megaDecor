<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->date('fechaApertura')->nullable();
            $table->time('horaApertura')->nullable();
            $table->time('horaCierre')->nullable();
            $table->string('aperturaBillete1000')->nullable();
            $table->string('aperturaBillete500')->nullable();
            $table->string('aperturaBillete200')->nullable();
            $table->string('aperturaBillete100')->nullable();
            $table->string('aperturaBillete50')->nullable();
            $table->string('aperturaBillete20')->nullable();
            $table->string('aperturaMoneda10')->nullable();
            $table->string('aperturaMoneda5')->nullable();
            $table->string('aperturaMoneda2')->nullable();
            $table->string('aperturaMoneda1')->nullable();
            $table->string('aperturaCentavo50')->nullable();
            $table->string('cierreBillete1000')->nullable();
            $table->string('cierreBillete500')->nullable();
            $table->string('cierreBillete200')->nullable();
            $table->string('cierreBillete100')->nullable();
            $table->string('cierreBillete50')->nullable();
            $table->string('cierreBillete20')->nullable();
            $table->string('cierreMoneda10')->nullable();
            $table->string('cierreMoneda5')->nullable();
            $table->string('cierreMoneda2')->nullable();
            $table->string('cierreMoneda1')->nullable();
            $table->string('cierreCentavo50')->nullable();
            $table->double('cantidadApertura')->nullable();
            $table->double('cantidadRealApertura')->nullable();
            $table->double('cantidadCierre')->nullable();
            $table->double('cantidadRealCierre')->nullable();
            $table->boolean('estatus')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('cash_registers');
    }
}
