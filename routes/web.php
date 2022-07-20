<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;

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

Route::get('peta', [ContentController::class, 'peta']);
Route::post('peta-upload', [ContentController::class, 'petaUpload']);
Route::get('peta-delete', [ContentController::class, 'petaDelete']);

Route::get('monitoring', [ContentController::class, 'monitoring']);
Route::post('monitoring-upload', [ContentController::class, 'monitoringUpload']);
Route::get('monitoring-delete', [ContentController::class, 'monitoringDelete']);
