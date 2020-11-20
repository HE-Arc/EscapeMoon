<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedScenario;

class SaveController extends Controller
{
    public function fetchSavedScenarios()
    {
        return response()->json('Salut', 200);
    }

    public function createSave(Request $request)
    {
        
    }
}
