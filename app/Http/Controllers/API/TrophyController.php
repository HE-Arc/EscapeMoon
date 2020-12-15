<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Trophy;

class TrophyController extends Controller
{
    public function fetch(Request $request)
    {  
        return response()->json(Auth::user()->trophies, 200);
    }
}
