<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login-page', function () {
    return view('login');
})->name('login-page');

Route::post('/login', function () {
    return view('dashboard'); // change later
})->name('login');

Route::get('/register-page', function () {
    return view('register');
})->name('register-page');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');
