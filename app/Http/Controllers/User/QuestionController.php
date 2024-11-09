<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\QuestionStoreRequest;
use App\Models\Answer;
use App\Models\Option;
use App\Models\Question;
use App\Models\Vendor;
use App\Models\VendorSubmittion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::latest()->paginate(10);

        return view('user.question.index', compact('questions'));
    }

    public function show(Vendor $vendor, Question $question = null)
    {
        // return $question;
        // Retrieve the selected vendor
        // $vendor = Vendor::findOrFail($vendorId);

        if (!$question) {
            $question = $vendor->questions->first();
        }
        // return $question;

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
        return view('user.question.show', compact('vendor', 'question', 'nextQuestion', 'previousQuestion'));
    }


    // Step 4: Finish the survey
    public function finish(Vendor $vendor)
    {

        $questions = $vendor->questions;
        $totalWeight = 0;
        $totalScore = 0;
    
        foreach ($questions as $question) {
            $answer = $question->userAnswer(Auth::id());
    
            if ($answer) {
                $totalScore += $answer->score; 
            }
    
            if ($question->type == 'multiple_choice') {
                $q_opts = $question->options;
                foreach ($q_opts as $q_opt) {
                    $totalWeight += $q_opt->weight;
                }
            } else {
                $totalWeight += $question->weight;
            }
        }
    
        $totalScorePer = ($totalWeight > 0) ? ($totalScore / $totalWeight) * 100 : 0;

        // return $
        // $companyId = Auth::user()->userCompany->pluck('company_id')->first();
        // Retrieve the company_id of the authenticated user
$companyId = Auth::user()->userCompany ? Auth::user()->userCompany->company_id : null;


        VendorSubmittion::create([
            'user_id' => Auth::id(),
            'vendor_id' => $vendor->id,
            'percentage' => $totalScorePer,
            'company_id' => $companyId,
            'submitted' => true,
        ]);

        notyf()->success('Your Survey Submitted Successfully');
        return view('user.question.finish', compact('vendor'));
    }
}
