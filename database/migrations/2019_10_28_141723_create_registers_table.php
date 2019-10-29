<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo')->nullable();
            $table->integer('budget_id')->unsigned()->nullable();
            $table->string('motivo')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('cantidad')->nullable();
            $table->date('fechaCompra')->nullable();
            $table->date('fechaIngreso')->nullable();
            $table->string('proveedor')->nullable();
            $table->double('precio')->nullable();
            $table->string('factura')->nullable();
            $table->timestamps();

            //Relations
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('registers');
    }
}
