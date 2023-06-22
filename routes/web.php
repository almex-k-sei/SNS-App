<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserListController;
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

/* ログイン中のみアクセスできるルーティングのサンプル */
Route::get('/users_only', function(){
    return view('users_only');
})->middleware('auth'); /* auth ミドルウェアが認証状態を判定してくれる */

//ホーム画面
Route::get('/home', [UserListController::class, 'index'])->middleware('auth');
Route::post('/home',[UserListController::class, 'edit'])->middleware('auth');

Route::get('/message', [MessageController::class, 'index']
)->middleware('auth');

Route::post('/message', [MessageController::class, 'send']
)->middleware('auth');

require __DIR__.'/auth.php';
