<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scenario;

class GameController extends Controller
{
    public function click(Request $request)
    {
        return response()->json($request->position, 200);
    }
}
