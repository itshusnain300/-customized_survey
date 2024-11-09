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
        $submittedVendors = $user->submittedVendors;
        $userId = $user->id;

        return view('admin.vendor.submitted.index', compact('submittedVendors', 'userId'));
    }

    public function show(User $user, VendorSubmittion $vendor_submittion)
    {
        // $this->calculateAverageVendorPercentage($user);
        // return $user->teamUser($user);

        // return $vendor_submittion->vern;
        if ($user->type == 'customer') {
            $average = $this->calculateAverageVendorPercentageCustomer($user);
        }else{
            $average = $this->calculateAverageVendorPercentageUser($user);
        }
        $submitted_vendor = $vendor_submittion->vendor;
        // return $user->submittedVendors->map->vendor;
        return view('admin.vendor.submitted.show', compact('user', 'submitted_vendor', 'average')); // Pass both variables correctly
    }

    public function calculateAverageVendorPercentageUser(User $user)
    {
        // return 'ergve';
        // Get the submitted vendors for the current user
        $userSubmittedVendors = $user->submittedVendors;
        $userPercentages = $userSubmittedVendors->pluck('percentage')->filter(); // Get non-null percentages

       $teamUsers = User::where('company', $user->company)
            ->where('id', '!=', $user->id)
            ->where('type', 'customer')
            ->get();

        // Get percentages from team users' submitted vendors
       $teamPercentages = $teamUsers->flatMap(function ($teamUser) {
            return $teamUser->submittedVendors->pluck('percentage')->filter(); // Get non-null percentages
        });

        // Calculate total percentages and count for average
        $totalPercentages = $userPercentages->merge($teamPercentages);
        $average = $totalPercentages->isNotEmpty() ? $totalPercentages->average() : 0; // Calculate average

        return number_format($average, 2, '.', '');// Return the average percentage
    }

    public function calculateAverageVendorPercentageCustomer(User $user)
    {
        // return 'ergve';
        // Get the submitted vendors for the current user
        $userSubmittedVendors = $user->submittedVendors;
        $userPercentages = $userSubmittedVendors->pluck('percentage')->filter(); // Get non-null percentages

       $teamUsers = User::where('company', $user->company)
            // ->where('id', '!=', $user->id)   
            ->where('type', 'user')
            ->get();

        // Get percentages from team users' submitted vendors
       $teamPercentages = $teamUsers->flatMap(function ($teamUser) {
            return $teamUser->submittedVendors->pluck('percentage')->filter(); // Get non-null percentages
        });

        // Calculate total percentages and count for average
        $totalPercentages = $userPercentages->merge($teamPercentages);
        $average = $totalPercentages->isNotEmpty() ? $totalPercentages->average() : 0; // Calculate average

        return number_format($average, 2, '.', '');// Return the average percentage
    }

    public function showDiagram(User $user, VendorSubmittion $vendor_submittion)
    {
        // return $vendor_submittion;

        $submitted_vendor = $vendor_submittion->vendor;
        $questions = $vendor_submittion->vendor->questions;
        $totalScore = 0;

        foreach ($questions as $question) {
            $answer = $question->userAnswer($user->id); 
    
            if ($answer) {
                $totalScore += $answer->score;
            }
        }

        $categories = $vendor_submittion->vendor->questions()
        ->get() // Fetch all questions
        ->groupBy('category') // Group by category
        ->map(function ($questions) use ($user) {
            $totalScore = $questions->sum(function ($question) use ($user) {
                return $question->userAnswer($user->id)->score ?? 0; // Sum scores or 0 if not available
            });

            // Return the category name with its total score
            return [
                'category' => $questions->first()->category, // Get category name
                'score' => $totalScore // Total score for that category
            ];
        })
        ->values(); 

        $average = $this->calculateAverageVendorPercentage($user);
    
        response()->json([
            "name" => $vendor_submittion->vendor->title,
            "score" => $totalScore,
            "size" => 500000,
            "children" => $categories
        ]);

        return view('admin.vendor.submitted.diagram.show', compact('user', 'submitted_vendor', 'vendor_submittion', 'average')); // Pass both variables correctly
    }

    public function calculateDiagram(User $user, VendorSubmittion $vendor_submittion)
    {
        $submitted_vendor = $vendor_submittion->vendor;
        $questions = $vendor_submittion->vendor->questions;
        $totalScore = 0;

        foreach ($questions as $question) {
            $answer = $question->userAnswer($user->id); 
    
            if ($answer) {
                $totalScore += $answer->score;
            }
        }
        $categories = $vendor_submittion->vendor->questions()
        ->get() // Fetch all questions
        ->groupBy('category') // Group by category
        ->map(function ($questions) use ($user) {
            $totalScore = $questions->sum(function ($question) use ($user) {
                return $question->userAnswer($user->id)->score ?? 0; // Sum scores or 0 if not available
            });

            // Return the category name with its total score
            return [
                'category' => $questions->first()->category, // Get category name
                "size" => 300000,
                'score' => $totalScore // Total score for that category
            ];
        })
        ->values(); 

        $average = $this->calculateAverageVendorPercentage($user);
    
        return response()->json([
            "name" => $vendor_submittion->vendor->title,
            "score" => $totalScore,
            "size" => 500000,
            "children" => $categories
        ]);

    }
    
}
