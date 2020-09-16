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

Route::get('/', function () {
    for ($i = 1; $i <= 10; ++$i) {
        $exerciseNo = str_pad($i, 2, '0', STR_PAD_LEFT);
        $links[] = [
            'url' => '/exercise' . $exerciseNo,
            'text' => __('Exercise :no', ['no' => $exerciseNo]),
        ];
    }

    return view('welcome', [
        'links' => $links,
    ]);
});
