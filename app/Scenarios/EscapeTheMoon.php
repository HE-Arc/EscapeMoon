<?php

namespace App\Scenarios;

use App\Scenarios\Scenario;
use App\Models\SavedItem;
use App\Models\SavedScene;
use App\Models\Inventory;

class EscapeTheMoon
{
    public static function click($savedScenario, $savedScene, $position)
    {
        switch($savedScene->scene_id)
        {
            case 1:
                return EscapeTheMoon::clickMaintenanceRoomScene($savedScenario, $savedScene, $position);
            case 2:
                return EscapeTheMoon::clickToolCabinetScene($savedScenario, $savedScene, $position);
        }
    }

    private static function pickItem($itemId, $savedScenarioId)
    {
        $savedItem = SavedItem::where([
            ['saved_scenario_id', $savedScenarioId],
            ['item_id', $itemId],
        ])->first();

        if($savedItem->picked == false)
        {
            $savedItem->inventory = true;
            $savedItem->picked = true;
            $savedItem->save();

            return array('add_items' => [$savedItem]);
        }
    }

    private static function changeScene($sceneId, $savedScenario)
    {
        $next_saved_scene = SavedScene::where([
            ['saved_scenario_id', $savedScenario->id],
            ['scene_id', $sceneId],
        ])->first();

        $savedScenario->last_saved_scene_id = $next_saved_scene->id;
        $savedScenario->save();

        return array('change_scene' => $next_saved_scene);
    }

    //=======================================================
    //Salle de maintenance
    //=======================================================

    private static function clickMaintenanceRoomScene($savedScenario, $savedScene, $position)
    {
        if($position[0] >= 0.2779 && $position[0] <= 0.3402 && $position[1] >= 0.6987 && $position[1] <= 0.7186)
            return EscapeTheMoon::pickItem(1, $savedScenario->id);
        else if($position[0] >= 0.7783 && $position[0] <= 0.9132 && $position[1] >= 0.7492 && $position[1] <= 0.8012)
            return EscapeTheMoon::pickItem(2, $savedScenario->id);
        else if($position[0] >= 0.4544 && $position[0] <= 0.6761 && $position[1] >= 0.3730 && $position[1] <= 0.7660)
            return EscapeTheMoon::changeScene(2, $savedScenario);
        else if($position[0] >= 0.7878 && $position[0] <= 0.8883 && $position[1] >= 0.4587 && $position[1] <= 0.7339)
            return EscapeTheMoon::clickMRDoor($savedScenario);
    }

    private static function clickMRDoor($savedScenario)
    {
        $doorKey = SavedItem::where([
            ['item_id', 2],
            ['saved_scenario_id', $savedScenario->id],
        ])->first();

        if($doorKey->inventory == true)
        { 
            $doorKey->inventory = false;
            $doorKey->save();
            $response = EscapeTheMoon::changeScene(3, $savedScenario);
            $response['remove_items'] = [$doorKey];
            return $response;
        }

        return array();
    }

    //=======================================================
    //Armoire à outils
    //=======================================================

    private static function clickToolCabinetScene($savedScenario, $savedScene, $position)
    {
        if($position[0] >= 0.0103 && $position[0] <= 0.0678 && $position[1] >= 0.0107 && $position[1] <= 0.0779)
            return EscapeTheMoon::changeScene(1, $savedScenario);
        else if($position[0] >= 0.5592 && $position[0] <= 0.6408 && $position[1] >= 0.3379 && $position[1] <= 0.3914)
            return EscapeTheMoon::pickItem(3, $savedScenario->id);
        else if($position[0] >= 0.3539 && $position[0] <= 0.4458 && $position[1] >= 0.5091 && $position[1] <= 0.5856)
            return EscapeTheMoon::pickItem(5, $savedScenario->id);
    }
}
