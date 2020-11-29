<?php

namespace App\Scenarios;

use App\Scenarios\Scenario;
use App\Models\SavedItem;
use App\Models\SavedScene;
use App\Models\Inventory;

class EscapeTheMoon
{
    public static function click($saved_scenario, $saved_scene, $position)
    {
        switch($saved_scene->scene_id)
        {
            case 1:
                return EscapeTheMoon::clickMaintenanceRoomScene($saved_scenario, $saved_scene, $position);
            case 2:
                return EscapeTheMoon::clickToolCabinetScene($saved_scenario, $saved_scene, $position);
        }
    }

    private static function pickItem($item_id, $saved_scenario_id)
    {
        $saved_item = SavedItem::where([
            ['saved_scenario_id', $saved_scenario_id],
            ['item_id', $item_id],
        ])->first();

        if($saved_item->picked == false)
        {
            $saved_item->inventory = true;
            $saved_item->picked = true;
            $saved_item->save();

            return array('add_items' => [$saved_item]);
        }
    }

    private static function changeScene($scene_id, $saved_scenario)
    {
        $next_saved_scene = SavedScene::where([
            ['saved_scenario_id', $saved_scenario->id],
            ['scene_id', $scene_id],
        ])->first();

        $saved_scenario->last_saved_scene_id = $next_saved_scene->id;
        $saved_scenario->save();

        return array('change_scene' => $next_saved_scene);
    }

    //=======================================================
    //Salle de maintenance
    //=======================================================

    private static function clickMaintenanceRoomScene($saved_scenario, $saved_scene, $position)
    {
        if($position[0] >= 0.2779 && $position[0] <= 0.3402 && $position[1] >= 0.6987 && $position[1] <= 0.7186)
            return EscapeTheMoon::pickItem(1, $saved_scenario->id);
        else if($position[0] >= 0.7783 && $position[0] <= 0.9132 && $position[1] >= 0.7492 && $position[1] <= 0.8012)
            return EscapeTheMoon::pickItem(2, $saved_scenario->id);
        else if($position[0] >= 0.4544 && $position[0] <= 0.6761 && $position[1] >= 0.3730 && $position[1] <= 0.7660)
            return EscapeTheMoon::changeScene(2, $saved_scenario);
        else if($position[0] >= 0.7878 && $position[0] <= 0.8883 && $position[1] >= 0.4587 && $position[1] <= 0.7339)
            return EscapeTheMoon::clickMRDoor($saved_scenario);
    }

    private static function clickMRDoor($saved_scenario)
    {
        $door_key = SavedItem::where([
            ['item_id', 2],
            ['saved_scenario_id', $saved_scenario->id],
        ])->first();

        if($door_key->inventory == true)
        { 
            $door_key->inventory = false;
            $door_key->save();
            $response = EscapeTheMoon::changeScene(3, $saved_scenario);
            $response['remove_items'] = [$door_key];
            return $response;
        }

        return array();
    }

    //=======================================================
    //Armoire à outils
    //=======================================================

    private static function clickToolCabinetScene($saved_scenario, $saved_scene, $position)
    {
        if($position[0] >= 0.0103 && $position[0] <= 0.0678 && $position[1] >= 0.0107 && $position[1] <= 0.0779)
            return EscapeTheMoon::changeScene(1, $saved_scenario);
        else if($position[0] >= 0.5592 && $position[0] <= 0.6408 && $position[1] >= 0.3379 && $position[1] <= 0.3914)
            return EscapeTheMoon::pickItem(3, $saved_scenario->id);
        else if($position[0] >= 0.3539 && $position[0] <= 0.4458 && $position[1] >= 0.5091 && $position[1] <= 0.5856)
            return EscapeTheMoon::pickItem(5, $saved_scenario->id);
    }
}
