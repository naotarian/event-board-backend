<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
    Route::post('/event_detail', 'event_detail');
    Route::post('/event_tag_search', 'event_tag_search');
    Route::get('/get_tags', 'get_tags');
    Route::post('/event_application', 'event_application');
    Route::post('/event_contact', 'event_contact');
});
Route::controller(UserController::class)->group(function(){
    Route::post('/user_info', 'user_info');
    Route::get('/my_page', 'my_page');
});