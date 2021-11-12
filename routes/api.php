<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FatorahController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('pay','FatorahController@payOrder');
// Route::get('/pay', 'App\Http\Controllers\FatorahController@payOrder');
Route::get('/pay', [FatorahController::class, 'payOrder']);
Route::get('/call_back',[FatorahController::class,'paymentCallBack']);
