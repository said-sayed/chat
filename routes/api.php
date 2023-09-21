<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')
    ->as('auth.')
    ->group(function () {

        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('login_with_token', [AuthController::class, 'loginWithToken'])
            ->middleware('auth:sanctum')
            ->name('login_with_token');
        Route::get('logout', [AuthController::class, 'logout'])
            ->middleware('auth:sanctum')
            ->name('logout');

    });



Route::middleware('auth:sanctum')->group(function (){
    Route::post('chat', [ChatController::class , 'index']);
    Route::post('chat/store', [ChatController::class , 'store']);
    Route::get('chat', [ChatController::class , 'show']);
    // Route::apiResource('chat_message', ChatMessageController::class)->only(['index','store']);
    // Route::apiResource('user', UserController::class)->only(['index']);

});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('chat', [ChatController::class, 'index']);
    Route::post('chat/store', [ChatController::class, 'store']);
    Route::get('chat', [ChatController::class, 'show']);

    Route::post('message', [ChatMessageController::class, 'index']);
    Route::post('message/store', [ChatMessageController::class, 'store']);

});
