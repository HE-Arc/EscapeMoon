<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditItemsCollumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['position_x', 'position_y']);
            $table->dropForeign(['scene_id']);
            $table->renameColumn('scene_id', 'scenario_id');
            $table->foreign('scenario_id')->references('id')->on('scenarios')->onDelete('cascade');
            $table->string('description')->default('');
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
            $table->dropForeign(['scenario_id']);
            $table->renameColumn('scenario_id', 'scene_id');
            $table->foreign('scene_id')->references('id')->on('scenes');
            $table->float('position_x')->default(0.0);
            $table->float('position_y')->default(0.0);
            $table->dropColumn('description');
        });
    }
}
