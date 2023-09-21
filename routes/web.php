<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\HomeController;
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
    return view('layouts.app');
});
Route::get('/chatView', function ($chat) {
    dd($chat);
    return $chat;
    return view('chat');
});
// Route::get('/chatView/{chat?}', function (string $chat = null) {
//     return $chat;
// });

Route::get('/contacts', function () {
    return view('contacts');
});

Auth::routes();

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/search', [HomeController::class, 'search'])->name('home');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('contacts', [ChatController::class, 'index']);
    Route::get('showChat/{chat_id}', [ChatController::class, 'showChat']);
    Route::post('chat/store', [ChatController::class, 'store']);
    // Route::get('chat', [ChatController::class, 'show']);

    Route::post('message', [ChatMessageController::class, 'index']);
    Route::get('allMessage/{chat_id}', [ChatMessageController::class, 'allMessage']);
    Route::post('message/store', [ChatMessageController::class, 'store']);
});
