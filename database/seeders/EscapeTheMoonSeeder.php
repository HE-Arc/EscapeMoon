<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Scenario;
use App\Models\Scene;

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
        ]);

        $scenario = Scenario::where('name', 'Escape the moon')->first();

        DB::table('scenes')->insert([
            'scenario_id' => $scenario->id,
            'name' => 'Le dortoir',
        ]);

        $first_scene = Scene::where('name', 'Le dortoir')->first();
        $scenario->first_scene_id = $first_scene->id;
        $scenario->save();
    }
}
