<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SubmittedVendorController;
use App\Http\Controllers\Admin\UserCompanyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware( 'auth', CheckAdmin::class)
    ->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('vendor', VendorController::class);
        Route::resource('question', QuestionController::class);

        // USer Route //
        Route::put('user/{user}/active', [UserController::class, 'active'])->name('user.active.update');
        Route::resource('user', UserController::class);

        // Submitted Vendors //
    Route::get('user/{user}/submitted-vendors', [SubmittedVendorController::class, 'index'])->name('user.submitted_vendors');
    Route::get('user/{user}/submitted-vendor/{vendor_submittion}', [SubmittedVendorController::class, 'show'])->name('user.submitted_vendor.show');
    
    Route::get('user/{user}/submitted-vendor/diagram/{vendor_submittion}', [SubmittedVendorController::class, 'showDiagram'])->name('user.submitted_vendor.show_diagram');
    

    // Company Routes
    Route::resource('company', CompanyController::class);

    // User Company Routes
    Route::post('user-company', [UserCompanyController::class, 'update'])->name('user.assign.company');

    // Route::get('user/{user}/vendor_submittion/{vendor_submittion}/graph/data', [SubmittedVendorController::class, 'calculateDiagram'])->name('graph.data');
    // web.php
    Route::get('/admin/graph/data/user/{user}/vendor_submittion/{vendor_submittion}', [SubmittedVendorController::class, 'calculateDiagram'])->name('graph.data');

    // Route::get('submitted-vendor/{vendor_submittion}');
});