<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SavedScene;
use App\Models\SavedScenario;

class SavedSceneController extends Controller
{
    public function fetch(request $request)
    {
        $request->validate([
            'saved_scenario_id' => 'required|integer',
        ]);

        $savedScenes = SavedScene::where('saved_scenario_id', $request->saved_scenario_id)->get();

        return response()->json($savedScenes, 200);
    }
}
