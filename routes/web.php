<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmittedVendorController;
use App\Http\Controllers\User\AnswerController;
use App\Http\Controllers\User\QuestionController;
use App\Http\Controllers\User\VendorController;
use App\Models\Package;
use App\Models\Question;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $packages = Package::all();
    return view('index', compact('packages'));
});
Route::get('package/{package}/payment', function (Package $package) {
    return view('payment', compact('package'));
})->name('package.payment');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::prefix('user')
    ->name('user.')
    ->middleware('auth')
    ->group(function () {
        
        Route::get('dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');

        Route::resource('vendor', VendorController::class);
        // Route::resource('question', QuestionController::class);

        Route::get('/survey/vendor/{vendor}/question/{question?}', [QuestionController::class, 'show'])->name('question.show');

        Route::post('/survey/vendor/{vendor}/question/{question?}', [AnswerController::class, 'saveAnswer'])->name('question.saveAnswer');

        Route::get('/survey/{vendor}/finish', [QuestionController::class, 'finish'])->name('survey.finish');

        Route::get('user/{user}/submitted-vendor/{vendor_submittion}', [SubmittedVendorController::class, 'show'])->name('user.submitted_vendor.show');
    });
    Route::get('submitted-vendors', [SubmittedVendorController::class, 'index'])->name('submitted_vendors');
    Route::get('user/submitted-vendor/{vendor_submittion}', [SubmittedVendorController::class, 'show'])->name('submitted_vendor.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/customer.php';
