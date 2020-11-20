<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crafts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('first_item_id');
            $table->unsignedBigInteger('second_item_id');
            $table->unsignedBigInteger('result_item_id');

            $table->foreign('first_item_id')->references('id')->on('items');
            $table->foreign('second_item_id')->references('id')->on('items');
            $table->foreign('result_item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crafts', function (Blueprint $table) {
            $table->dropForeign(['first_item_id']);
            $table->dropForeign(['second_item_id']);
            $table->dropForeign(['result_item_id']);
        });
        Schema::dropIfExists('crafts');
    }
}
