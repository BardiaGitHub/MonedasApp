<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonedaController;

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

Route::resource('moneda', MonedaController::class);
Route::delete('image/{id}', [MonedaController::class, 'deleteImage'])->name('image.delete');
Route::post('moneda/search/{value}', [MonedaController::class, 'search'])->name('moneda.search');