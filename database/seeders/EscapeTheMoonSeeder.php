<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscapeTheMoonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('scenarios')->insert([
            'name' => 'Escape the moon',
            'first_scene_id' => 1,
        ]);

        DB::table('scenes')->insert([
            'scenario_id' => 1,
            'name' => 'Le dortoir',
        ]);
    }
}
