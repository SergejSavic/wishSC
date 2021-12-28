<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\InitController;
use App\Http\Controllers\SupportController;
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

Route::get('dashboard', ['uses' => '\\' . \App\Http\Controllers\DashboardController::class . '@getViewData'])->name('.wish.dashboard');

Route::middleware(['sendcloud.support'])->group(static function () {
    Route::group(['prefix' => 'v1', 'as' => 'v1'], static function () {
        Route::get('support', ['uses' => '\\' . SupportController::class . '@index'])->name('.support.get');
        Route::post('support', ['uses' => '\\' . SupportController::class . '@update'])->name('.support.post');
    });
});

Route::group(['prefix' => 'v1', 'as' => 'v1'], static function () {
    Route::post('connect', ['uses' => '\\' . ConnectController::class . '@connect'])->name('.connect');
});
