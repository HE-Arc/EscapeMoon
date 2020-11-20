<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaveController extends Controller
{
    public function fetchSavedScenarios()
    {
        return response()->json('Salut', 200);
    }
}
