<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
})->name('welcome');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
  Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('', [HomeController::class, 'index'])->name('index');
  });

  Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('', [UserController::class, 'index'])->name('index');
    Route::post('store/{id?}', [UserController::class, 'store'])->name('store');
  });

  Route::group(['prefix' => 'location', 'as' => 'location.'], function () {
    Route::get('',[LocationController::class,'index'])->name('index');
    Route::post('store/{id?}',[LocationController::class,'store'])->name('store');
  });
});
