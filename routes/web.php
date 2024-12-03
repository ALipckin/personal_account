<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
})->name('home'); // Главная страница

Route::get('/comments', function () {
    return view('comments');
})->name('comments'); // Страница с комментариями

Route::get('/authentication', function () {
    return view('authentication');
})->name('authentication'); // Страница авторизации

Route::get('/password-recovery', function () {
    return view('password-recovery');
})->name('password.recovery'); // Страница восстановления пароля

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy.policy'); // Страница политики конфиденциальности

Route::get('/profile', function () {
    return view('profile');
})->name('profile'); // Страница профиля пользователя

