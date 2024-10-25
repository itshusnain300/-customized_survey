<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuestionStoreRequest;
use App\Models\Option;
use App\Models\Question;
use App\Models\Vendor;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::latest()->paginate(10);

        return view('admin.question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = Vendor::latest()->get();

        return view('admin.question.create', compact('vendors'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionStoreRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $isTypeMultipleOpts = $validatedData['type'] === 'multiple_choice' ? true : false;

            $options = $validatedData['options'];

            $question = Question::create($validatedData);

            if ($isTypeMultipleOpts && count($options) > 1) {
                foreach ($options as $key => $option) {
                    Option::create([
                        'title' => $option,
                        'question_id' => $question->id,
                    ]);
                }
            }
            // $admin->notyf(new NewadminJobRequestRecevied($admin));

            notyf()->success('New question successfully created.');
            return back();
        } catch (\Throwable $th) {
            throw $th;
            notyf()->error('Failed to create admin. Please try again.SCDS');
        }

        // event(new Registered($admin));
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        // return $question->options();
        return view('admin.question.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $vendors = Vendor::latest()->get();

        return view('admin.question.update', compact('question', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionStoreRequest $request, Question $question)
    {
        $validatedData = $request->validated();

        try {
            $questionId = $question->id;

            $isTypeMultipleOpts = $validatedData['type'] === 'multiple_choice' ? true : false;

            $options = $validatedData['options'];

            $question->update($validatedData);

            if ($isTypeMultipleOpts && count($options) > 1) {

                $question->options;

                $previousOptions = $question->options;

                if (count($previousOptions) > 0) {
                    foreach ($previousOptions as $opt) {
                        $opt->delete();
                    }
                }

                foreach ($options as $key => $option) {
                    Option::create([
                        'title' => $option,
                        'question_id' => $questionId,
                    ]);
                }
            }

            notyf()->success('question successfully updated.');
            return back();
        } catch (\Throwable $th) {
            throw $th;
            notyf()->error('Failed to create admin. Please try again.SCDS');
        }

        // event(new Registered($admin));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        try {
            $question->delete();
            notyf()->success('question successfully deleted.');
            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
