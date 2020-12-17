<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditSavedItemsCollumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saved_items', function (Blueprint $table) {
            $table->dropForeign(['saved_scene_id']);
            $table->renameColumn('saved_scene_id', 'saved_scenario_id');
            $table->foreign('saved_scenario_id')->references('id')->on('saved_scenarios')->onDelete('cascade');
            $table->dropForeign(['inventory_id']);
            $table->dropColumn('inventory_id');
            $table->boolean('inventory')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saved_items', function (Blueprint $table) {
            $table->dropColumn('inventory');
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->foreign('inventory_id')->references('id')->on('inventories')->ondelete('set null');
            $table->dropForeign(['saved_scenario_id']);
            $table->renameColumn('saved_scenario_id', 'saved_scene_id');
            $table->foreign('saved_scene_id')->references('id')->on('scenes')->ondelete('cascade');
        });
    }
}
