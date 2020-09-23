<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clouds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('budget_id')->unsigned()->nullable();
            $table->text('motivo')->nullable();
            $table->date('fechaAnterior');
            $table->date('fechaNueva');
            $table->string('categoriaAnterior');
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
        Schema::dropIfExists('clouds');
    }
}
