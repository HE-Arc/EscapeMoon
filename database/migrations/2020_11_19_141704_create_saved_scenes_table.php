<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedScenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_scenes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scene_id')->nullable();
            $table->unsignedBigInteger('saved_scenario_id')->nullable();
            $table->boolean('locked')->default(true);

            $table->foreign('scene_id')->references('id')->on('scenes')->onDelete('cascade');
            $table->foreign('saved_scenario_id')->references('id')->on('saved_scenarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saved_scenes', function (Blueprint $table) {
            $table->dropForeign(['scene_id']);
            $table->dropForeign(['saved_scenario_id']);
        });
        
        Schema::dropIfExists('saved_scenes');
    }
}
