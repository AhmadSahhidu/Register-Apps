<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::post('actionLogin', function () {
    return view('pages.dashboard');
})->name('action-login');
