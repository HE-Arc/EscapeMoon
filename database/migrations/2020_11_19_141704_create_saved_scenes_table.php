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
            $table->unsignedBigInteger('scene_id');
            $table->unsignedBigInteger('saved_scenario_id');
            $table->boolean('locked');

            $table->foreign('scene_id')->references('id')->on('scenes');
            $table->foreign('saved_scenario_id')->references('id')->on('saved_scenarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_scenes');
    }
}