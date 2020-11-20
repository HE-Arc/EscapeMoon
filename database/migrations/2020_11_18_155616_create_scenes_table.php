<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scenes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scenario_id')->nullable();
            $table->string('name')->default("No Name");

            $table->foreign('scenario_id')->references('id')->on('scenarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scenes', function (Blueprint $table) {
            $table->dropForeign(['scenario_id']);
        });

        Schema::dropIfExists('scenes');
    }
}
