<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedScene;
use App\Models\SavedScenario;
use App\Models\Craft;
use App\Models\SavedItem;
use App\Scenarios\EscapeTheMoon;

class GameController extends Controller
{
    public function click(Request $request)
    {
        $request->validate([
            'saved_scene_id' => 'required|integer',
            'position' => 'required',
        ]);

        $savedScene = SavedScene::where('id', $request->saved_scene_id)->first();
        $savedScenario = SavedScenario::where('id', $savedScene->saved_scenario_id)->first();

        switch($savedScenario->scenario_id)
        {
            case 1:
                $response = EscapeTheMoon::click($savedScenario, $savedScene, $request->position);
                break;
        }

        return response()->json($response, 200);
        //return response()->json($request->position, 200);
    }

    public function craft(Request $request)
    {
        $request->validate([
            'saved_scene_id' => 'required|integer',
            'first_item_id' => 'required|integer',
            'second_item_id' => 'required|integer',
        ]);

        $savedScene = SavedScene::where('id', $request->saved_scene_id)->first();
        $savedScenario = SavedScenario::where('id', $savedScene->saved_scenario_id)->first();
        $resultSavedItem = $this->getCraftItem($request->first_item_id, $request->second_item_id, $savedScenario);
        $response = array();

        if($resultSavedItem != null)
        {
            $firstSavedItem = SavedItem::where([['item_id', $request->first_item_id], ['saved_scenario_id', $savedScenario->id]])->first();
            $secondSavedItem = SavedItem::where([['item_id', $request->second_item_id], ['saved_scenario_id', $savedScenario->id]])->first();
            $firstSavedItem->inventory = false;
            $secondSavedItem->inventory = false;
            $resultSavedItem->inventory = true;
            $firstSavedItem->save();
            $secondSavedItem->save();
            $resultSavedItem->save();

            $response['remove_items'] = [$firstSavedItem, $secondSavedItem];
            $response['add_items'] = [$resultSavedItem];
        }

        return response()->json($response, 200);
    }

    private function getCraftItem($firstItemId, $secondItemId, $savedScenario)
    {
        $craft = Craft::where([['first_item_id', $firstItemId], ['second_item_id', $secondItemId]])->first();
        if($craft == null)
            $craft = Craft::where([['first_item_id', $secondItemId], ['second_item_id', $firstItemId]])->first();
        if($craft == null)
            return null;

        return SavedItem::where([['item_id', $craft->result_item_id], ['saved_scenario_id', $savedScenario->id]])->first();
    }
}
