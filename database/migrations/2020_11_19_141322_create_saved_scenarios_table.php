<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedScenariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_scenarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('scenario_id')->nullable();
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->unsignedBigInteger('last_saved_scene_id')->nullable();
            $table->dateTime('creation')->nullable();
            $table->dateTime('last_save')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('scenario_id')->references('id')->on('scenarios');
            $table->foreign('inventory_id')->references('id')->on('inventories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saved_scenarios', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['scenario_id']);
            $table->dropForeign(['inventory_id']);
        });

        Schema::dropIfExists('saved_scenarios');
    }
}
