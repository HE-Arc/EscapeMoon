<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedScenario;
use Illuminate\Support\Facades\Auth;

class SaveController extends Controller
{
    public function getSaves()
    {
        $saves = SavedScenario::where('id', Auth::id());
        return response()->json($saves, 200);
    }

    public function createSave(Request $request)
    {

    }
}
