<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDarkAndLight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saved_scenarios', function (Blueprint $table) {
            $table->boolean('flashlight')->default(false);
        });

        Schema::table('saved_scenes', function (Blueprint $table) {
            $table->boolean('dark');
        });

        Schema::table('scenes', function (Blueprint $table) {
            $table->boolean('dark')->default(false);
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
            $table->dropColumn('flashlight');
        });

        Schema::table('saved_scenes', function (Blueprint $table) {
            $table->dropColumn('dark');
        });

        Schema::table('scenes', function (Blueprint $table) {
            $table->dropColumn('dark');
        });
    }
}
