<?php

namespace App\Http\Controllers\Customer;

// use App\Http\Controllers\Admin\Controller;

use App\Models\Company;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function companyIndex()
    {
        $companies = Company::latest()->get();

        return view('customer.company.index', compact('companies'));
    }
    public function submittedCompanyIndex()
    {
        // return 'sves';
        // /Users/talha/Desktop/CustomizedSurvey/resources/views/customer/company/submitted/index.blade.php
        // return Auth::user()->submittedVendors->map->ven;
        $submittedVendors = Auth::user()->submittedVendors;

        return view('customer.company.submitted.index', compact('submittedVendors'));
    }

    public function show(Company $company)
    {

        $packageType = Auth::user()->customerPackage->package->type ?? 'Default Type';
        $vendors = [];

        if ($packageType == 'basic') {
            $vendors = $company->companySets->map->vendor
                ->filter(function ($vendor) {
                    return in_array($vendor->type, ['basic_set', 'advanced_set']);
                })
                ->values();
        } else {
            $vendors = $company->companySets->map->vendor
                ->filter(function ($vendor) {
                    return $vendor->type === 'customer_specific';
                })
                ->values();
        }

        // Get the first vendor with submissions
        $vendorWithSubmissions = $vendors->first(function ($vendor) {
            return isset($vendor->vendorSubmissions) && $vendor->vendorSubmissions->isNotEmpty();
        });

        // Safely access user if vendorWithSubmissions is found
        $user = $vendorWithSubmissions ? $vendorWithSubmissions->vendorSubmissions->first()->user : null;

        // Safely access the first vendor submission
        $vendor_submission = $vendorWithSubmissions ? $vendorWithSubmissions->vendorSubmissions->first() : null;
        return view('customer.vendor.index', compact('vendors', 'company', 'packageType', 'user', 'vendor_submission'));
    }
    public function index()
    {
        // Retrieve vendors that do not have any submissions
        // $vendors = Vendor::doesntHave('vendorSubmissions')->latest()->paginate(10);
        $vendors = (new Vendor())->customerVendors();

        return view('customer.vendor.index', compact('vendors'));
    }
}
