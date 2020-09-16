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

Route::prefix('exercise01')->group(function () {
    Route::get('/', 'OrderController@showForm');
    Route::post('/', 'OrderController@create');
});
