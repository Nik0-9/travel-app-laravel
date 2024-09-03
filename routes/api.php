<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\DayController;
use App\Http\Controllers\Api\StopController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/trips', [TripController::class, 'index']);
Route::post('/new-trip', [TripController::class, 'store']);
Route::get('/trips/{id}', [TripController::class, 'show']);
Route::post('/trips/{tripId}/days', [DayController::class, 'store']);
Route::get('/trips/{tripsId}/days/{day_id}', [DayController::class, 'show']);
Route::get('/trips/{tripId}/days/{dayId}/stops', [StopController::class, 'index']);
Route::post('/trips/{tripId}/days/{dayId}/stops', [StopController::class, 'store']);

// Route::prefix('trips/{tripId}/days')->group(function () {
//     Route::get('/', [DayController::class, 'index']);
//     Route::post('/', [DayController::class, 'store']);
// });
