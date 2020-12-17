<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Scenario;

class ScenarioController extends Controller
{
    public function fetchScenarios()
    {
        return response()->json(Scenario::all(), 200);
    }
}
