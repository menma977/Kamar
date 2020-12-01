<?php

use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\UserController;
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

Route::post('login', [UserController::class, 'login']);
Route::get('logout', [UserController::class, 'logout']);

Route::middleware('auth:api')->group(function () {
  Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('show', [UserController::class, 'show']);
  });
  Route::group(['prefix' => 'room', 'as' => 'room.'], function () {
    Route::get('{room?}', [RoomController::class, 'index']);
    Route::post("rent", [RoomController::class, 'rent']);
    Route::post("store", [RoomController::class, 'store']);
    Route::post('delete', [RoomController::class, 'delete']);
  });

  Route::group(['prefix' => 'location', 'as' => 'location' ], function () {
      Route::get('show',[LocationController::class,'show']);
      Route::post('store',[LocationController::class,'store']);
  });

});
