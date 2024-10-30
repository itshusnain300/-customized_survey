<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\QuestionStoreRequest;
use App\Models\Answer;
use App\Models\Company;
use App\Models\Option;
use App\Models\Question;
use App\Models\Vendor;
use App\Models\VendorSubmittion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    // Step 3: Save the answer and move to the next question
    public function saveAnswer(Request $request,Company $company, Vendor $vendor, Question $question)
    {
        // return $question;
        $score = 0; // Default score

        // Check the question type and determine the score based on the user's answer
        if ($question->type === 'yes_no') {
            // If the answer is "yes", set the score to the question's weight (if any), otherwise 0
            $score = $request->answer === 'yes' ? $question->weight ?? 1 : 0;
        } elseif ($question->type === 'multiple_choice') {
            // Multiple choice: Calculate the score based on the weight of the selected options
            // dd($request->answer);
            $selectedOptions = explode(',', $request->answer); // Assuming selected options are comma-separated
            $totalScore = 0;

            // dd($selectedOptions);
            // dd($question->options);

            foreach ($question->options as $option) {
                if (in_array($option['title'], $selectedOptions)) {
                    $totalScore += $option['weight'];
                }
            }
            $score = $totalScore;
        } elseif ($question->type === 'text') {
            // Open text: If there's no weight for the question, set the score to 0
            $score = $question->weight ?? 0;
        } elseif ($question->type === 'valid/invalid') {
            // Valid/Failed: If the answer is "valid", set the score to the question's weight, otherwise 0
            // dd($request->answer);
            $score = $request->answer === 'vaild' ? $question->weight ?? 1 : 0;
        }

        // Update or create the answer record with the calculated score
        Answer::updateOrCreate(
            [
                'vendor_id' => $vendor->id,
                'question_id' => $question->id,
                'user_id' => Auth::id(),
            ],
            [
                'answer_text' => $request->answer,
                'score' => $score, // Save the calculated score
            ],
        );

        $nextQuestion = $vendor->questions
            ->sortBy('id')
            ->where('id', '>', $question->id)
            ->first();

        if ($nextQuestion) {
            return redirect()->route('customer.question.show', ['vendor' => $vendor, 'question' => $nextQuestion->id,
            'company' => $company->id,
        ]);
        }

        $questions = $vendor->questions;
        $totalWeight = 0;
        $totalScore = 0;
    

        $user = Auth::user();

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

        // $companyId = Auth::user()->userCompany->pluck('company_id')->first();
        $companyId = $company->id;

        $vendor_submittion =  VendorSubmittion::create([
            'user_id' => Auth::id(),
            'vendor_id' => $vendor->id,
            'percentage' => $totalScorePer,
            'company_id' => $companyId,
            'submitted' => true,
        ]);

        // If no more questions, redirect to a summary or finish page
        return redirect()->route('customer.survey.finish', ['vendor' => $vendor->id, 'company' => $company->id ,'vendor_submittion' => $vendor_submittion->id ]);
        // return redirect()->route('customer.survey.finish', ['vendor' => $vendor->id, 'company' => $company->id ]);
    }
}
