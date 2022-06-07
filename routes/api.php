<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(EventController::class)->group(function(){
    Route::post('/create_event', 'create_event');
    Route::get('/get_events', 'get_events');
    Route::post('/event_search', 'event_search');
});
Route::controller(UserController::class)->group(function(){
    Route::post('/user_info', 'user_info');
});
