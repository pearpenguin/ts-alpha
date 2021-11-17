<?php

use App\Http\Controllers\GameResultController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// TODO: protected routes
Route::prefix('/game-results')->group(function () {
    Route::post('/', [GameResultController::class, 'store']);
});

Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
});
