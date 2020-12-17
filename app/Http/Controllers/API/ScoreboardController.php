<?php

namespace App\Http\Controllers\API;

use App\Models\SavedScenario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreboardController extends Controller
{
    public function getEscapeMoonScoreboard(Request $request)
    {
        $saves = DB::table('saved_scenarios')
            ->join('scenarios', 'saved_scenarios.scenario_id', 'scenarios.id')
            ->join('users', 'saved_scenarios.user_id', 'users.id')
            ->select('users.name', 'saved_scenarios.time')
            ->where('scenarios.name', 'Escape the moon')
            ->where('saved_scenarios.finished', true)
            ->limit(10)
            ->orderBy('saved_scenarios.time')
            ->get();

        return response()->json($saves, 200);
    }
}
