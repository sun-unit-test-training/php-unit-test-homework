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

Route::prefix('exercise08')->group(function () {
    Route::get('/', 'TicketController@index')->name('ticket.index');
    Route::post('calculate', 'TicketController@calculatePrice')->name('ticket.calculate');
});
