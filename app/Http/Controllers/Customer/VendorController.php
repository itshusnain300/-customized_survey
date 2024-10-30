<?php

namespace App\Http\Controllers\Customer;

// use App\Http\Controllers\Admin\Controller;

use App\Http\Requests\VendorStoreRequest;
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
    public function show(Company $company)
    {
        $packageType = Auth::user()->customerPackage->package->type;
        $vendors = [];

        if ($packageType == 'basic') {
                $vendors = $company->companySets->map->vendor
                ->filter(function ($vendor) {
                    return in_array($vendor->type, ['basic_set', 'advanced_set']);
                })
                ->values();
            
                $user = $vendors->first(function ($vendor) {
                    // Check if the vendor has any submissions
                    return $vendor->vendorSubmissions->isNotEmpty();
                })->vendorSubmissions->first()->user ?? null; 
        }else{
            $vendors = $company->companySets->map->vendor
            ->filter(function ($vendor) {
                return $vendor->type === 'customer_specific';
            })
            ->values();
        }

           
        $user = $vendors->first(function ($vendor) {
            // Check if the vendor has any submissions
            return $vendor->vendorSubmissions->isNotEmpty();
        })->vendorSubmissions->first()->user ?? null; 


        // return $vendors->map(function ($vendor) {
        //     if ($vendor->vendorSubmissions->isNotEmpty()) {
        //         // Return the user from the first vendor submission
        //         return $vendor->vendorSubmissions->first()->user;
        //     }
        //     return null;
        // });
        $vendor_submittion = $vendors->first(function ($vendor) {
            // Check if the vendor has any submissions
            return $vendor->vendorSubmissions->isNotEmpty();
        })->vendorSubmissions->first() ?? null; 
        

        return view('customer.vendor.index', compact('vendors', 'company', 'packageType', 'user', 'vendor_submittion'));
    }

    public function index()
    {
        // Retrieve vendors that do not have any submissions
        // $vendors = Vendor::doesntHave('vendorSubmissions')->latest()->paginate(10);
        $vendors = (new Vendor())->customerVendors();

        return view('customer.vendor.index', compact('vendors'));
    }
}
