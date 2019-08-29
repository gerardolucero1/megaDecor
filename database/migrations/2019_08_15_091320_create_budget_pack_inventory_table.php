<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetPackInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_pack_inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_pack_id')->unsigned();
            $table->integer('inventory_id')->unsigned();

            $table->timestamps();

            //Relation
            $table->foreign('budget_pack_id')->references('id')->on('budget_packs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('inventory_id')->references('id')->on('inventories')
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
        Schema::dropIfExists('budget_pack_inventory');
    }
}
