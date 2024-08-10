<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('index', ['name' => 'test']);
});

//login blade
Route::get('/login', function () {
    return view('login');
});

Route::get('/upload', function () {
    return view('upload');
});







//admin side

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/product', function () {
    return view('admin.product');
});

Route::get('/template', function () {
    return view('admin.error');
});