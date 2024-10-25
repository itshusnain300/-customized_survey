<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Admin\Controller;

use App\Http\Requests\VendorStoreRequest;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorSubmittion;

class SubmittedVendorController extends Controller
{
    
    public function index(User $user)
    {
        $submitted_vendors = $user->submittedVendors;
        $userId = $user->id;

        return view('admin.vendor.submitted.index', compact('submitted_vendors', 'userId'));
    }
    
    public function show(User $user, VendorSubmittion $vendor_submittion)
    {
        // return $vendor_submittion->vern;
        $submitted_vendor = $vendor_submittion->vendor;
        // return $user->submittedVendors->map->vendor;
        return view('admin.vendor.submitted.show', compact('user', 'submitted_vendor')); // Pass both variables correctly
        
    }
    
    public function showDiagram(User $user, VendorSubmittion $vendor_submittion)
    {
        // return $vendor_submittion->vern;
        $submitted_vendor = $vendor_submittion->vendor;
        // return $user->submittedVendors->map->vendor;
        return view('admin.vendor.submitted.diagram.show', compact('user', 'submitted_vendor')); // Pass both variables correctly
        
    }

}
