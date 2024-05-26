<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('tasks.index');
    }
    return redirect()->route('auth.login');
})->name('home'); */

Route::get('login', function () {
    return view('auth.login');
})->name('auth.login');

Route::get('register', function () {
    return view('auth.register');
})->name('auth.register');

Route::get('calendar', function () {
    return view('calendar.index');
})->name('calendar');

Route::get('account', function () {
    return view('users.account');
})->name('users.account');

Route::get('/chat/{user}', [MessageController::class, 'showChatWithUser'])->name('chat');

Route::resource('tasks', TaskController::class);
Route::resource('categories', CategoryController::class);
Route::resource('messages', MessageController::class);
Route::resource('scores', ScoreController::class);
Route::resource('users', UserController::class);

Route::middleware('auth:sanctum')->group(function () {

});


