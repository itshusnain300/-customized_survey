<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Admin\Controller;

use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorSubmittion;

class SubmittedVendorController extends Controller
{
    public function index(User $user)
    {
        $submittedVendors = VendorSubmittion::with('user')
            ->whereHas('user', function ($query) {
                $query->where('type', 'user');
            })
            ->latest()
            ->get();

        return view('vendor.index', compact('submittedVendors', ));
    }

    public function show(User $user, VendorSubmittion $vendor_submittion)
    {
        
        // $this->calculateAverageVendorPercentage($user);
        // return $user->teamUser($user);

        // return $vendor_submittion->vern;
        // $average = $this->calculateAverageVendorPercentage($user);
        $submitted_vendor = $vendor_submittion->vendor;
        $userId = $vendor_submittion->user_id;
        // dd('usercheck');
        // return $user->submittedVendors->map->vendor;
        return view('vendor.submitted.show', compact('user', 'submitted_vendor', 'userId')); // Pass both variables correctly
    }

    // public function calculateAverageVendorPercentage(User $user)
    // {
    //     // Get the submitted vendors for the current user
    //     $userSubmittedVendors = $user->submittedVendors;
    //     $userPercentages = $userSubmittedVendors->pluck('percentage')->filter(); // Get non-null percentages

    //     $teamUsers = User::where('company', $user->company)
    //         ->where('id', '!=', $user->id)
    //         ->get();

    //     // Get percentages from team users' submitted vendors
    //    $teamPercentages = $teamUsers->flatMap(function ($teamUser) {
    //         return $teamUser->submittedVendors->pluck('percentage')->filter(); // Get non-null percentages
    //     });

    //     // Calculate total percentages and count for average
    //     $totalPercentages = $userPercentages->merge($teamPercentages);
    //     $average = $totalPercentages->isNotEmpty() ? $totalPercentages->average() : 0; // Calculate average

    //     return number_format($average, 2, '.', '');// Return the average percentage
    // }
}
