<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'api', 'namespace' => 'App\Http\Controllers'], function () {
    Route::resource('user', 'UserController');
});

