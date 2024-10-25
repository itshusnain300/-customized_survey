<?php

namespace App\Http\Controllers\Customer;

// use App\Http\Controllers\Admin\Controller;

use App\Http\Requests\VendorStoreRequest;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        // Retrieve vendors that do not have any submissions
        // $vendors = Vendor::doesntHave('vendorSubmissions')->latest()->paginate(10);
        $vendors = (new Vendor)->customerVendors();
        
        return view('customer.vendor.index', compact('vendors'));
    }
}
