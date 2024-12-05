<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProfileController;
use \App\Http\Controllers\CommentsController;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/', function () {
    return view('index');
})->name('home'); // Главная страница

Route::get('/comments', [CommentsController::class, 'index'])->name('comments');

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

Route::middleware('auth')
    ->patch('/profile', [ProfileController::class, 'update'])
    ->name('profile');

Route::middleware('auth')
    ->post('/profile/photo', [ProfileController::class, 'uploadPhoto'])
    ->name('profile.photo.update');


require __DIR__.'/auth.php';
