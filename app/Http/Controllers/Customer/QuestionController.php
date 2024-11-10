<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\QuestionStoreRequest;
use App\Models\Answer;
use App\Models\Company;
use App\Models\Option;
use App\Models\Question;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorSubmittion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::latest()->paginate(10);

        return view('customer.question.index', compact('questions'));
    }

    public function show(Company $company, Vendor $vendor, Question $question = null)
    {
        // return $vendor;
        if (!$question) {
            $question = $vendor->questions->first();
        }

        if ($vendor->questions && count($vendor->questions) > 0) {
            $questions = $vendor->questions->sortBy('id'); // Sort the questions by 'id'
    
            $nextQuestion = $questions->where('id', '>', $question->id)->first(); 
            $previousQuestion = $questions->where('id', '<', $question->id)->last(); 
        }else{
            notyf()->warning('vendor'  . $vendor->title . 'has no questions');
            return back();
        }
        // Retrieve next and previous questions for navigation
        
            // return $nextQuestion;
        return view('customer.question.show', compact('vendor', 'question', 'nextQuestion', 'previousQuestion',
        'company',
    ));
    }


    // Step 4: Finish the survey
    public function finish(Company $company, Vendor $vendor, VendorSubmittion $vendor_submittion)
    {
       
        $user = Auth::user();
        $average = $this->calculateAverageVendorPercentage($user);
        
        $submitted_vendor = $vendor_submittion->vendor;

        // $average = $this->calculateAverageVendorPercentage($user);

        notyf()->success('Your Survey Submitted Successfully');
        return view('customer.company.submitted.show', compact('user', 'submitted_vendor', 'vendor_submittion', 'average'));
        // return view('customer.question.finish', compact('vendor', 'company',));
    }
    
    public function showSubmittedVendor(Vendor $vendor, VendorSubmittion $vendor_submittion)
    {
    //    return $vendor_submittion;
        $user = Auth::user();
        $average = $this->calculateAverageVendorPercentage($user);
        
        $submitted_vendor = $vendor_submittion->vendor;

        // $average = $this->calculateAverageVendorPercentage($user);

        notyf()->success('Your Survey Submitted Successfully');
        return view('customer.company.submitted.show', compact('user', 'submitted_vendor', 'vendor_submittion', 'average'));
        // return view('customer.question.finish', compact('vendor', 'company',));
    }

    public function calculateAverageVendorPercentage(User $user)
    {
        // Get the submitted vendors for the current user
        $userSubmittedVendors = $user->submittedVendors;
        $userPercentages = $userSubmittedVendors->pluck('percentage')->filter(); // Get non-null percentages

        $teamUsers = User::where('company', $user->company)
            ->where('id', '!=', $user->id) 
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
}   
