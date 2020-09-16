<?php

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

Route::prefix('exercise05')->group(function () {
    Route::get('/', 'Exercise05Controller@index');
    Route::post('/', 'Exercise05Controller@store')->name('store_discount');
});
