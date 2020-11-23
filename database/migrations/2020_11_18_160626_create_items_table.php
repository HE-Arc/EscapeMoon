<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scene_id')->nullable();
            $table->string('name')->default("No Name");
            $table->float('position_x')->default(0.0);
            $table->float('position_y')->default(0.0);

            $table->foreign('scene_id')->references('id')->on('scenes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['scene_id']);
        });

        Schema::dropIfExists('items');
    }
}
