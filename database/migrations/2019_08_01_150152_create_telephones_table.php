<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelephonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telephones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->string('nombre')->nullable();
            $table->string('apellidoPaterno')->nullable();
            $table->string('apellidoMaterno')->nullable();
            $table->string('email')->nullable();
            $table->enum('tipo', ['CASA', 'CELULAR', 'OFICINA']);
            $table->string('numero');
            $table->integer('ext')->nullable();
            $table->timestamps();

            //Relations
            $table->foreign('client_id')->references('id')->on('clients')
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
        Schema::dropIfExists('telephones');
    }
}
