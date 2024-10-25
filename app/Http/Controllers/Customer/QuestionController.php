<?php

namespace App\Http\Controllers\Customer;

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

        return view('customer.question.index', compact('questions'));
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
        return view('customer.question.show', compact('vendor', 'question', 'nextQuestion', 'previousQuestion'));
    }


    // Step 4: Finish the survey
    public function finish(Vendor $vendor)
    {
        VendorSubmittion::create([
            'user_id' => Auth::id(),
            'vendor_id' => $vendor->id,
            'submitted' => true,
        ]);

        notyf()->success('Your Survey Submitted Successfully');
        return view('customer.question.finish', compact('vendor'));
    }
}
