@extends('customer.layouts.app')

@section('main')
    <style>
        .question-type-icon {
            font-size: 1.5rem;
            color: #007bff;
        }

        .answer-box {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .answer-label {
            font-weight: bold;
        }

        .company-logo {
            height: 50px;
        }
    </style>

    @php
    $questions = $submitted_vendor->questions;
    $totalWeight = 0;
    $totalScore = 0;

    foreach ($questions as $question) {
        $answer = $question->userAnswer($user->id); // Assuming 'answer' is the relation to the Answer model

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

    // Calculate the percentage only after the loop
    $totalScorePer = ($totalWeight > 0) ? ($totalScore / $totalWeight) * 100 : 0;

    // @dd($totalWeight);
    @endphp


    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active"> Submitted Vendors</li>
                    <li class="breadcrumb-item active"> Show</li>
                </ol>
            </nav>
        </div>

        <section class="container mt-5">
            <!-- Company Logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('assets/img/fill-online-surveys-google-forms-questionnaire-and-polls.png') }}"
                    alt="Company Logo" class="company-logo">
            </div>

            <!-- Header -->
            <h2 class="text-center mb-4">User Submitted Questions & Answers</h2>

            <div class="d-flex justify-content-between align-item-center mb-4">
                <h2 class="">
                    <a href="{{ route('customer.user.submitted_vendor.show_diagram', ['user' => Auth::id(), 'vendor_submittion' => $vendor_submittion->id]) }}" class="btn btn-primary">Spider Diagram</a>
                </h2>
    
                <h2 class="">
                    Total Score: {{ number_format($totalScorePer, 2) }}% [{{ $totalWeight }}]
                </h2>

            </div>

            <h5 class="text-end mb-4">
                {{-- @if($user->teamUser($user) && $user->teamUser($user)->submittedVendors->isNotEmpty()) --}}
                @if($average)
                    Average: {{ $average }}%
                @else
                    Notes: No submissions from your team user yet.
                @endif
            </h5>
            

            <!-- List of Questions and Answers -->
            @foreach ($questions as $question)
                <div class="answer-box p-4 shadow-sm">
                    <!-- Question -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">{{ $question->title }}</h5>
                        <div>
                            <!-- Icons based on question type -->
                            @if ($question->type == 'open_text')
                                <i class="fas fa-keyboard question-type-icon" title="Open Text"></i>
                            @elseif($question->type == 'multiple_choice')
                                <i class="fas fa-list-ul question-type-icon" title="Multiple Choice"></i>
                            @elseif($question->type == 'yes_no')
                                <i class="fas fa-check-circle question-type-icon" title="Yes/No"></i>
                            @elseif($question->type == 'valid_failed')
                                <i class="fas fa-times-circle question-type-icon" title="Valid/Failed"></i>
                            @elseif($question->type == 'file')
                                <i class="fas fa-file-upload question-type-icon" title="File"></i>
                            @endif
                        </div>
                    </div>

                    @php
                        // Retrieve the user's answer as a comma-separated string
                        $userAnswer = $question->userAnswer($user->id)->answer_text ?? null;
                        $q_score = $question->userAnswer($user->id)->score ?? null;

                    @endphp

                    <!-- Answer Section -->
                    <div class="mb-2">
                        <span class="answer-label">Answer:</span>

                        <!-- Display based on the type of question -->
                        @if ($question->type == 'text')
                            <p>{{ $userAnswer }}</p>
                        @elseif($question->type == 'multiple_choice')
                            @if ($userAnswer)
                                <ul>
                                    @foreach (explode(',', $userAnswer) as $answer)
                                        <li>{{ trim($answer) }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <li>No Answer Submitted</li>
                            @endif
                        @elseif($question->type == 'yes_no')
                            <p>{{ $question->userAnswer($user->id)->answer_text}}</p>
                        @elseif($question->type == 'valid_failed')
                            <p>{{ $answer_text == '1' ? 'Valid' : 'Failed' }}</p>
                        @elseif($question->type == 'file')
                            <a href="{{ asset('storage/uploads/' . $answer_file) }}" target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download File
                            </a>
                        @endif
                    </div>

                    <div class="mb-2">
                        <span class="answer-label">Score:</span>

                        <p>{{ $q_score ?? 'No Score' }}</p>
                    </div>

                    <!-- Submission Metadata (optional) -->
                    <div class="text-muted">
                        <small>Submitted by {{ $user->name }} on {{ $user->created_at->format('d M Y, h:i A') }}</small>
                    </div>
                </div>
            @endforeach
        </section>

    </main>
@endsection
