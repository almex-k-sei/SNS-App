<?php

use App\Http\Controllers\GroupListController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageListController;
use App\Models\User;

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
Route::get('/Home', [UserListController::class, 'index'])->middleware('auth');
Route::post('/Home',[UserListController::class, 'edit'])->middleware('auth');

//友達になりたい人を検索
Route::get('search_friend',[UserListController::class,'search_index'])->middleware('auth');
Route::post('search_friend',[UserListController::class,'search_friend'])->middleware('auth');

//友達追加
Route::post('/add_friend',[UserListController::class,'add_friend'])->middleware('auth');

/* トーク画面
トークルームIDが初回はpostでredierct時はget */
Route::get('/Message', [MessageController::class, 'index'])->middleware('auth');
Route::post('/Message', [MessageController::class, 'index'])->middleware('auth');
/* メッセージの送信 */
Route::post('/Message/send', [MessageController::class, 'send'])->middleware('auth');

/* メッセージリスト画面 */
Route::get('/MessageList', [MessageListController::class, 'index'])->middleware('auth');
Route::post('/MessageList/add', [MessageListController::class, 'add_talkroom'])->middleware('auth');

//新規登録時のusersテーブルとprofilesテーブルの結び付け
Route::post('dashboard',[UserController::class,'create'])->middleware('auth');
Route::get('/GroupList', [GroupListController::class, 'index'])->middleware('auth');

Route::post('/GroupList/add', [GroupListController::class, 'add'])->middleware('auth');

Route::post('/GroupList/quit', [GroupListController::class, 'quit'])->middleware('auth');

Route::post('/GroupList/delete', [GroupListController::class, 'delete'])->middleware('auth');

require __DIR__.'/auth.php';
