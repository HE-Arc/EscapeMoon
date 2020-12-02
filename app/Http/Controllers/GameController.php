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

        $saved_scene = SavedScene::where('id', $request->saved_scene_id)->first();
        $saved_scenario = SavedScenario::where('id', $saved_scene->saved_scenario_id)->first();

        switch($saved_scenario->scenario_id)
        {
            case 1:
                $response = EscapeTheMoon::click($saved_scenario, $saved_scene, $request->position);
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

        $saved_scene = SavedScene::where('id', $request->saved_scene_id)->first();
        $saved_scenario = SavedScenario::where('id', $saved_scene->saved_scenario_id)->first();
        $result_saved_item = $this->getCraftItem($request->first_item_id, $request->second_item_id, $saved_scenario);
        $response = array();

        if($result_saved_item != null)
        {
            $first_saved_item = SavedItem::where([['item_id', $request->first_item_id], ['saved_scenario_id', $saved_scenario->id]])->first();
            $second_saved_item = SavedItem::where([['item_id', $request->second_item_id], ['saved_scenario_id', $saved_scenario->id]])->first();
            $first_saved_item->inventory = false;
            $second_saved_item->inventory = false;
            $result_saved_item->inventory = true;
            $first_saved_item->save();
            $second_saved_item->save();
            $result_saved_item->save();

            $response['remove_items'] = [$first_saved_item, $second_saved_item];
            $response['add_items'] = [$result_saved_item];
        }

        return response()->json($response, 200);
    }

    private function getCraftItem($first_item_id, $second_item_id, $saved_scenario)
    {
        $craft = Craft::where([['first_item_id', $first_item_id], ['second_item_id', $second_item_id]])->first();
        if($craft == null)
            $craft = Craft::where([['first_item_id', $second_item_id], ['second_item_id', $first_item_id]])->first();
        if($craft == null)
            return null;

        return SavedItem::where([['item_id', $craft->result_item_id], ['saved_scenario_id', $saved_scenario->id]])->first();
    }
}
