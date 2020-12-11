<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ScenarioController;
use App\Http\Controllers\API\SavedScenarioController;
use App\Http\Controllers\API\SavedSceneController;
use App\Http\Controllers\API\SavedItemController;
use App\Http\Controllers\API\GameController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/test", function(Request $request)
{
    return response()->json("Test OK, the API is available!", 200);
});

Route::get("/test/{client_secret}", function(Request $request)
{
    if ($request->client_secret == config('services.passport.client_secret'))
    {
        return response()->json("TEST OK, the API is available and the client secret is correctly configured!", 200);
    }
    return response()->json("ERROR, something went wrong... check that you correctly configured the client secret!", 400);
});

Route::middleware('auth:api')->group(function ()
{
    Route::post("/logout", [AuthController::class, "logout"]);
    Route::get("/scenarios", [ScenarioController::class, "fetchScenarios"]);
    Route::get("/save", [SavedScenarioController::class, "fetch"]);
    Route::post("/save/create", [SavedScenarioController::class, "create"]);
    Route::post("/save/delete", [SavedScenarioController::class, "delete"]);
    Route::post("/save/resume", [SavedScenarioController::class, "resume"]);
    Route::post("/scene", [SavedSceneController::class, "fetch"]);
    Route::post("/inventory", [SavedItemController::class, "inventory"]);
    Route::post("/game/click", [GameController::class, "click"]);
    Route::post("/game/craft", [GameController::class, "craft"]);
});

Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);
