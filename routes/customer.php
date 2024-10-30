<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\AnswerController;
use App\Http\Controllers\Customer\QuestionController;
use App\Http\Controllers\Customer\SubmittedVendorController;
use App\Http\Controllers\Customer\VendorController;
use App\Http\Controllers\User\VendorController as UserVendorController;
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
        
        Route::get('/companies', [VendorController::class, 'companyIndex'])->name('companies');

        Route::get('/company/{company}/vendor', [VendorController::class, 'show'])->name('company.vendors');

        Route::get('/survey/company/{company}/vendor/{vendor}/question/{question?}', [QuestionController::class, 'show'])->name('question.show');

        Route::post('/survey/company/{company}vendor/{vendor}/question/{question?}', [AnswerController::class, 'saveAnswer'])->name('question.saveAnswer');

        Route::get('/survey/company/{company}/vendor/{vendor}/vendor_submittion/{vendor_submittion}/finish', [QuestionController::class, 'finish'])->name('survey.finish');

        Route::get('user/{user}/submitted-vendor/{vendor_submittion}', [SubmittedVendorController::class, 'show'])->name('user.submitted_vendor.show');
 
        // Spider Diagram Routes //

        Route::get('user/{user}/submitted-vendor/diagram/{vendor_submittion}', [SubmittedVendorController::class, 'showDiagram'])->name('user.submitted_vendor.show_diagram');

        Route::get('/admin/graph/data/user/{user}/vendor_submittion/{vendor_submittion}', [SubmittedVendorController::class, 'calculateDiagram'])->name('graph.data');
});
