<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SavedScene;
use App\Models\SavedScenario;
use App\Models\Craft;
use App\Models\SavedItem;
use App\Scenarios\EscapeTheMoon;
use Carbon\Carbon;

class GameController extends Controller
{
    public function click(Request $request)
    {
        $request->validate([
            'saved_scene_id' => 'required|integer',
            'position' => 'required',
        ]);

        $savedScene = SavedScene::where('id', $request->saved_scene_id)->with('savedScenario')->firstOrFail();
        $savedScenario = $savedScene->savedScenario;

        switch($savedScenario->scenario_id)
        {
            case 1:
                $response = EscapeTheMoon::click($savedScenario, $savedScene, $request->position);
                break;
        }

        $savedScenario->last_save = Carbon::now()->addHours(1);
        $savedScenario->save();
        
        return response()->json($response, 200);
    }

    public function craft(Request $request)
    {
        $request->validate([
            'saved_scene_id' => 'required|integer',
            'first_item_id' => 'required|integer',
            'second_item_id' => 'required|integer',
        ]);

        $savedScene = SavedScene::where('id', $request->saved_scene_id)->with('savedScenario')->firstOrFail();
        $savedScenario = $savedScene->savedScenario;
        $craft = DB::table('crafts')
            ->where('first_item_id', $request->first_item_id)
            ->where('second_item_id', $request->second_item_id)
            ->orWhere('first_item_id', $request->second_item_id)
            ->where('second_item_id', $request->first_item_id)
            ->first();

        if($craft != null)
        {
            $firstSavedItem = SavedItem::where([['item_id', $craft->first_item_id], ['saved_scenario_id', $savedScenario->id]])->firstOrFail();
            $secondSavedItem = SavedItem::where([['item_id', $craft->second_item_id], ['saved_scenario_id', $savedScenario->id]])->firstOrFail();
            $resultSavedItem = SavedItem::where([['item_id', $craft->result_item_id], ['saved_scenario_id', $savedScenario->id]])->firstOrFail();
            $firstSavedItem->inventory = false;
            $secondSavedItem->inventory = false;
            $resultSavedItem->inventory = true;
            $firstSavedItem->save();
            $secondSavedItem->save();
            $resultSavedItem->save();

            $response['remove_items'] = [$firstSavedItem, $secondSavedItem];
            $response['add_items'] = [$resultSavedItem];
        }

        $savedScenario->last_save = Carbon::now()->addHours(1);
        $savedScenario->save();

        return response()->json($response, 200);
    }
}
