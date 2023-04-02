<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PassportAuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\VocabularyController;
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
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login'])->name("login");
Route::resource('lesson', LessonController::class);
Route::resource('vocabulary', VocabularyController::class);
Route::middleware('auth:api')->group(function () {
    Route::resource('user', UserController::class);

});
