<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FatorahController;
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
Route::post('/', function () {
    return view('welcome');
});

Route::get('callback',function(){
    return 'success';
});
Route::get('error',function(){
    return 'payment failed';
});

Route::get('/a', function () {
    return view('inde');
});
Route::get('/b', function () {
    return view('index');
});

// Route::get('/pay','FatorahController@payOrder');
// Route::get('/pay', 'App\Http\Controllers\FatorahController@payOrder');
Route::get('/pay', [FatorahController::class, 'payOrder']);

Route::get('/call_back',[FatorahController::class,'paymentCallBack']);
