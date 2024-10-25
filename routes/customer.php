<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\AnswerController;
use App\Http\Controllers\Customer\QuestionController;
use App\Http\Controllers\Customer\VendorController;
use App\Models\Question;
use Illuminate\Support\Facades\Route;

Route::prefix('customer')
    ->name('customer.')
    ->middleware('auth')
    ->group(function () {
        
        Route::get('dashboard', function () {
            return view('customer.dashboard');
        })->name('dashboard');

        Route::resource('vendor', VendorController::class);
        // Route::resource('question', QuestionController::class);

        Route::get('/survey/vendor/{vendor}/question/{question?}', [QuestionController::class, 'show'])->name('question.show');

        Route::post('/survey/vendor/{vendor}/question/{question?}', [AnswerController::class, 'saveAnswer'])->name('question.saveAnswer');

        Route::get('/survey/{vendor}/finish', [QuestionController::class, 'finish'])->name('survey.finish');
});
