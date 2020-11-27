<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\SavedScenario;
use App\Models\SavedItem;

class InventoryController extends Controller
{
    public function fetch(Request $request)
    {
        $saved_scenario = SavedScenario::where('id', $request->saved_scenario_id)->first();
        $inventory = Inventory::where('id', $saved_scenario->inventory_id)->first();
        $saved_items = SavedItem::where('inventory_id', $inventory->id)->get();

        return response()->json($saved_items, 200);
    }
}
