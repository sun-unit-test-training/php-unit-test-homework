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

Route::prefix('exercise07')->group(function () {
    Route::get('/', 'CheckoutController@index')->name('checkout.index');
    Route::post('/', 'CheckoutController@store')->name('checkout.store');
});
