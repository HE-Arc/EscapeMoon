<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Scenario;
use App\Models\Scene;
use App\Models\Item;
use App\Models\Craft;

class EscapeTheMoonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scenario = Scenario::create([
            'name' => 'Escape the moon',
        ]);

        $maintenance_room = Scene::create([
            'scenario_id' => $scenario->id,
            'name' => 'Salle de maintenance',
        ]);

        $tool_cabinet = Scene::create([
            'scenario_id' => $scenario->id,
            'name' => 'Armoire à outils',
        ]);

        $library = Scene::create([
            'scenario_id' => $scenario->id,
            'name' => 'Librairie',
        ]);

        $screwdriver = Item::create([
            'scenario_id' => $scenario->id,
            'name' => 'Tournevis',
        ]);

        $library_key = Item::create([
            'scenario_id' => $scenario->id,
            'name' => 'Clé de la bibliothèque',
        ]);

        $flashlight_unpowered = Item::create([
            'scenario_id' => $scenario->id,
            'name' => 'Lampe de poche sans piles',
        ]);

        $flashlight = Item::create([
            'scenario_id' => $scenario->id,
            'name' => 'Lampe de poche',
        ]);

        $radio = Item::create([
            'scenario_id' => $scenario->id,
            'name' => 'Radio',
        ]);

        $batteries = Item::create([
            'scenario_id' => $scenario->id,
            'name' => 'Piles',
        ]);

        Craft::create([
            'first_item_id' => $screwdriver->id,
            'second_item_id' => $radio->id,
            'result_item_id' => $batteries->id,
        ]);

        Craft::create([
            'first_item_id' => $batteries->id,
            'second_item_id' => $flashlight_unpowered->id,
            'result_item_id' => $flashlight->id,
        ]);

        $scenario->first_scene_id = $maintenance_room->id;
        $scenario->save();
    }
}
