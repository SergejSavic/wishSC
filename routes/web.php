<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\InitController;
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
});

Route::get('callback', ['uses' => '\\' . AuthController::class . '@index'])->name('.wish.auth');
Route::post('init', ['uses' => '\\' . InitController::class . '@init'])->name('.wish.init');

Route::group(['prefix' => 'v1', 'as' => 'v1'], static function () {
    Route::post('connect', ['uses' => '\\' . ConnectController::class . '@connect'])->name('.connect');
});
