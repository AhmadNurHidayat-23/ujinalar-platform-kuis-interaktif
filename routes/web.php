<?php

use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', [QuizController::class, 'index'])->name('home');
Route::get('/kuis/{category}', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/kuis/{category}/hasil', [QuizController::class, 'submit'])->name('quiz.submit');
