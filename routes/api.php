<?php

use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\PassportAuthController;
use App\Http\Controllers\Api\PracticeController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ResultController;
use App\Http\Controllers\Api\VocabularyController;
use App\Http\Controllers\Api\PracticeSubmit;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenStudent;
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

Route::middleware(['auth:api'])->group(function () {
    Route::resource('practice', PracticeController::class);
    Route::resource('submit', PracticeSubmit::class);
    Route::resource('student', StudentController::class)->middleware(EnsureTokenStudent::class);
    Route::resource('lesson', LessonController::class);
    Route::resource('vocabulary', VocabularyController::class);
    Route::resource('result', ResultController::class);
});
