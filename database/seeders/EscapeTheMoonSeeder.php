<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Scenario;
use App\Models\Scene;
use App\Models\Item;
use App\Models\Craft;
use App\Models\Trophy;

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
            'dark' => true,
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

        $access_card = Item::create([
            'scenario_id' => $scenario->id,
            'name' => 'Carte accès',
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

        Trophy::create([
            'name' => "Terminé : Escape the Moon",
            'description' => "Vous avez terminé le scénario Escape the moon",
        ]);

        Trophy::create([
            'name' => "Terminé : Salle de maintenance",
            'description' => "Vous êtes sorti de la salle de maintenance dans le scénario Escape the moon",
        ]);

        $scenario->first_scene_id = $maintenance_room->id;
        $scenario->save();
    }
}
