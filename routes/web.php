<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageListController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//ホーム画面
Route::get('/home', [UserListController::class, 'index'])->middleware('auth');
Route::post('/home',[UserListController::class, 'edit'])->middleware('auth');

Route::get('/message', [MessageController::class, 'index']
)->middleware('auth');

/* トークルームIDが初回は */
Route::get('/Message', [MessageController::class, 'index'])->middleware('auth');
Route::post('/Message', [MessageController::class, 'index'])->middleware('auth');

Route::post('/Message/send', [MessageController::class, 'send'])->middleware('auth');

Route::get('/MessageList', [MessageListController::class, 'index'])->middleware('auth');
Route::post('/message', [MessageController::class, 'send']
)->middleware('auth');

//新規登録時のusersテーブルとprofilesテーブルの結び付け
Route::post('dashboard',[UserController::class,'create'])->middleware('auth');

require __DIR__.'/auth.php';
