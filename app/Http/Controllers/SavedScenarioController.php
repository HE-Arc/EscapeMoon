<?php

namespace App\Http\Controllers;

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
            ->get();

        return response()->json($saves, 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'scenario_id' => 'required|integer',
        ]);

        $scenario = Scenario::where('id', $request->scenario_id)->first();
        $first_scene = Scene::where('id', $scenario->first_scene_id)->first();

        $saved_scenario = SavedScenario::create([
            'user_id' => Auth::id(),
            'scenario_id' => $scenario->id,
            'creation' => Carbon::now(),
            'last_save' => Carbon::now(),
        ]);

        $scenes = Scene::where('scenario_id', $scenario->id)->get();
        foreach($scenes as $scene)
        {
            $saved_scene = SavedScene::create([
                'saved_scenario_id' => $saved_scenario->id,
                'scene_id' => $scene->id,
            ]);

            if($scene->id == $first_scene->id)
            {
                $saved_scenario->last_saved_scene_id = $saved_scene->id;
                $saved_scene->locked = false;

                $saved_scenario->save();
                $saved_scene->save();
            }
        }

        $items = Item::where('scenario_id', $scenario->id)->get();
        foreach($items as $item)
        {
            $saved_item = SavedItem::create([
                'saved_scenario_id' => $saved_scenario->id,
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

        $saved_scenario = SavedScenario::where('id', $request->saved_scenario_id)->first();
        $saved_scenario->last_saved_scene_id = null;
        $saved_scenario->save();
        $saved_scenes = SavedScene::where('saved_scenario_id', $saved_scenario->id)->get();
        
        foreach($saved_scenes as $saved_scene)
            SavedItem::where('saved_scenario_id', $saved_scenario->id)->delete();

        SavedScene::where('saved_scenario_id', $saved_scenario->id)->delete();
        SavedScenario::where('id', $request->saved_scenario_id)->delete();

        return $this->fetch();
    }

    public function resume(Request $request)
    {
        $request->validate([
            'saved_scenario_id' => 'required|integer',
        ]);

        $saved_scenario = SavedScenario::where('id', $request->saved_scenario_id)->first();
        $saved_scene = SavedScene::where('id', $saved_scenario->last_saved_scene_id)->first();

        return response()->json($saved_scene, 200);
    }
}
