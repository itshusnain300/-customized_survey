<?php

use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SubmittedVendorController;
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
        Route::resource('user', UserController::class);

        // Submitted Vendors //
    Route::get('user/{user}/submitted-vendors', [SubmittedVendorController::class, 'index'])->name('user.submitted_vendors');
    Route::get('user/{user}/submitted-vendor/{vendor_submittion}', [SubmittedVendorController::class, 'show'])->name('user.submitted_vendor.show');
    Route::get('user/{user}/submitted-vendor/diagram/{vendor_submittion}', [SubmittedVendorController::class, 'showDiagram'])->name('user.submitted_vendor.show_diagram');
    
    Route::get('/graph/data', function () {
        return response()->json([
            "name" => "Customer Specific", "size" => 500000, "link" => "http://google.com",
            "children" => [
                ["name" => "Business Threats", "size" => 300000, "link" => "http://google.com"],
                ["name" => "Privacy and Compliance", "size" => 300000, "link" => "http://yahoo.com"],
                ["name" => "Operational Security ", "size" => 300000, "link" => "http://youtube.com"],
                ["name" => "Resiliency", "size" => 300000, "link" => "http://twitter.com"],
                ["name" => "Supply Chain", "size" => 300000, "link" => "http://facebook.com"],
                ["name" => "Data Protection ", "size" => 300000, "link" => "http://facebook.com"]
            ]
        ]);
    })->name('graph.data');
    // Route::get('submitted-vendor/{vendor_submittion}');
});
