<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierTelephonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_telephones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('proveedor_id')->unsigned();
            $table->string('nombre')->nullable();
            $table->string('numero')->nullable();
            $table->string('correo')->nullable();
            $table->string('tipo')->nullable();
            $table->string('ext')->nullable();
            $table->timestamps();

            //Relations
            $table->foreign('proveedor_id')->references('id')->on('suppliers')
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
        Schema::dropIfExists('supplier_telephones');
    }
}
