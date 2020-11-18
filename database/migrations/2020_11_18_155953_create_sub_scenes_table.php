<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubScenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_scene', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_scene_id');
            $table->unsignedBigInteger('sub_scene_id');
            $table->float('position_x')->default(0.0);
            $table->float('position_y')->default(0.0);

            $table->foreign('main_scene_id')->references('id')->on('scenes');
            $table->foreign('sub_scene_id')->references('id')->on('scenes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_scene');
    }
}
