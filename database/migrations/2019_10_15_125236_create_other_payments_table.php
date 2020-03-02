<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo')->nullable();
            $table->double('cantidad')->nullable();
            $table->string('motivo')->nullable();
            $table->string('responsable')->nullable();
            $table->string('banco')->nullable();
            $table->double('resto')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('metodo')->nullable();
            $table->string('referencia')->nullable();
            $table->string('contrato')->nullable();
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
        Schema::dropIfExists('other_payments');
    }
}
