<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contrato');
            $table->string('cliente')->unique();
            $table->string('fecha')->nullable();
            $table->string('vendedor');
            $table->string('lugar');
            $table->string('version');            
            $table->string('created_at')->nullable();
            $table->string('updated_at')->nullable();
            $table->string('opciones');
        });
    }
    /*
'contrato' => $faker->unique()->safeEmail,
        'cliente' => $faker->name,
        'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'vendedor' => $faker->name,
        'lugar' => $faker->state,
        'version' => $faker->creditCardExpirationDate,
        'created_at' => $faker->now(),
        'opciones' => $faker->sentence,
    */
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
