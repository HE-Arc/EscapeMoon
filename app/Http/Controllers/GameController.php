<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scenario;

class GameController extends Controller
{
    public function resume($request)
    {
        return response()->json($request->savedd_scenario_id, 200);
    }

    public function onClick($request)
    {

    }
}
