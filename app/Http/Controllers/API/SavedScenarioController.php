<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SavedScenario;
use App\Models\SavedScene;
use App\Models\Scenario;
use App\Models\Scene;
use App\Models\Item;
use App\Models\SavedItem;
use Illuminate\Support\Facades\Auth;

class SavedScenarioController extends Controller
{
    public function fetch()
    {
        $saves = DB::table('saved_scenarios')
            ->join('scenarios', 'saved_scenarios.scenario_id', 'scenarios.id')
            ->select('saved_scenarios.id', 'scenarios.name', 'saved_scenarios.creation', 'saved_scenarios.last_save')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($saves, 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'scenario_id' => 'required|integer',
        ]);

        $scenario = Scenario::where('id', $request->scenario_id)
            ->with('firstScene')
            ->with('items')
            ->with('scenes')
            ->firstOrFail();

        $savedScenario = SavedScenario::create([
            'user_id' => Auth::id(),
            'scenario_id' => $scenario->id,
            'creation' => Carbon::now()->addHours(1),
            'last_save' => Carbon::now()->addHours(1),
            'time' => 0,
        ]);

        
        foreach($scenario->scenes as $scene)
        {
            $savedScene = SavedScene::create([
                'saved_scenario_id' => $savedScenario->id,
                'scene_id' => $scene->id,
            ]);

            if($scene->id == $scenario->firstScene->id)
            {
                $savedScenario->last_saved_scene_id = $savedScene->id;
                $savedScene->locked = false;

                $savedScenario->save();
                $savedScene->save();
            }
        }

        
        foreach($scenario->items as $item)
        {
            $savedItem = SavedItem::create([
                'saved_scenario_id' => $savedScenario->id,
                'item_id' => $item->id,
            ]);
        }

        return $this->fetch();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'saved_scenario_id' => 'required|integer',
        ]);

        $savedScenario = SavedScenario::where('id', $request->saved_scenario_id)->delete();

        return $this->fetch();
    }

    public function resume(Request $request)
    {
        $request->validate([
            'saved_scenario_id' => 'required|integer',
        ]);

        $savedScenario = SavedScenario::where('id', $request->saved_scenario_id)->first();      
        $savedScenario->last_save = Carbon::now()->addHours(1);
        $savedScenario->save();

        $savedScene = SavedScene::where('id', $savedScenario->last_saved_scene_id)->first();

        return response()->json($savedScene, 200);
    }
}
