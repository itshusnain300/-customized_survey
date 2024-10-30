@extends('user.layouts.app')
@section('main')

    @php
        $options = $question->options;
        // @dd($question->title);
    @endphp

{{-- <style>
    .btn {
        background-color: #FCFBF8;
        cursor: pointer;
        font-size: 18px;
    }

    .checked {
        background-color: #0071A4;
        color: white;
    }

    .selected {
        background-color: #0071A4;
        color: white;
    }
</style> --}}
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="">Questions</a></li>
                    <li class="breadcrumb-item active">Show Question</li>
                </ol>
            </nav>
        </div>

        <section class="section py-5">
            <div class="container">
                <div id="questionContainer" class="d-flex flex-column">
            
                <div class="card shadow-sm">
                    <div class="card-body">
                        
                        <div class="mb-5 text-start">
                            <button style="border-radius: 0;" class="btn btn-primary">{{ $question->category }}</button>
                        </div>

                    <form method="POST" action="{{ route('user.question.saveAnswer', ['vendor' => $vendor->id, 'question' => $question->id]) }}" id="questionForm">
                        @csrf

                        {{-- <input type="hidden" name="question_id" value="{{ $question->id }}" id="question_id">
                        <input type="hidden" name="skip" id="skipInput"> --}}
                        
                        <input type="hidden" name="answer" id="selectedAnswer">
            
                        <div class="mb-3 text-center">
                            <h1 class="text-4xl font-semibold">{{ $question->title }}</h1>
                        </div>
            

                        @if ($question->description)
                        <div class="mb-3 text-center">
                            <p class="text-center">{!! $question->description !!}</p>
                        </div>
                    @endif
                    
                        @if ($question->type === 'yes_no')
                            <div id="yesNoOptions" class="d-flex flex-column justify-content-center align-items-center gap-3 p-3">
                                <button type="button" data-value="yes" class="btn btn-light py-3 px-4">Yes</button>
                                <button type="button" data-value="no" class="btn btn-light py-3 px-4">No</button>
                            </div>
                        @elseif ($question->type === 'multiple_choice')
                            <div class="d-flex justify-content-center align-items-center">

                                <div class="btn-group-vertical" role="group" aria-label="Basic radio toggle button group">
                                    @foreach ($question->options as $option)
                                        <input 
                                            type="radio" 
                                            class="btn-check checkbox-option" 
                                            name="question_option" 
                                            value="{{ $option->title }}" 
                                            id="btnradio{{ $option->id }}" 
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btnradio{{ $option->id }}">{{ $option->title }}</label>
                                    @endforeach
                                </div>
                                
                            </div>
                            
                        @elseif ($question->type === 'valid/invalid')
                            <div id="valid_faild_options" class="d-flex flex-column justify-content-center align-items-center gap-3 p-3">
                                <button type="button" data-value="vaild" class="btn btn-light py-3 px-4">Valid</button>
                                <button type="button" data-value="faild" class="btn btn-light py-3 px-4">Faild</button>
                            </div>

                        @elseif ($question->type === 'text')
                            <div class="d-flex justify-content-center my-4">
                                <input type="text" name="answer" id="textAnswer" placeholder="Enter Your Answer" class="form-control">
                            </div>
                        @endif
            
                        <div class="border-top w-100 mb-3"></div>
            
                        <div class="d-flex justify-content-center align-items-center">
                            {{-- <button type="button" class="btn btn-outline-secondary me-2" id="skipButton">Skip</button> --}}
                            <button type="button" class="btn btn-outline-secondary me-2" id="backButton">Back</button>
                            {{-- @if ($question->type !== 'yes_no') --}}
                                <button type="button" id="nextButton" class="btn btn-primary">Next</button>
                            {{-- @endif --}}
                        </div>
                    </form>

                    </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
    
            $('.card').on('click', function() {
                $(this).toggleClass('selected');
                let checkbox = $(this).find('.card-check');
                checkbox.prop('checked', !checkbox.prop('checked'));
                // console.log(checkbox.prop(''));
            });
    
            // Handle button clicks for yes_no questions
            $(document).on('click', '#yesNoOptions .btn', function() {
                $(".btn").removeClass("checked");
                $(this).addClass("checked");
                $("#selectedAnswer").val($(this).data('value'));
                $('#questionForm').submit(); // Set value for Yes/No questions
            });

            $(document).on('click', '#valid_faild_options .btn', function() {
                $(".btn").removeClass("checked");
                $(this).addClass("checked");
                $("#selectedAnswer").val($(this).data('value'));
                $('#questionForm').submit(); // Set value for Yes/No questions
            });
    
            // Handle checkbox selections for multiple_choice questions
            $(document).on('click', '.checkbox-option', function() {
                let selectedOptions = [];
                $('.checkbox-option:checked').each(function() {
                    selectedOptions.push($(this).val());
                });
                $("#selectedAnswer").val(selectedOptions.join(','));

            });
    
            // Skip button click event
            $(document).on('click', '#skipButton', function() {
                $('#skipInput').val('true');
                $('#questionForm').submit();
            });
    
            // Skip button click event
            $(document).on('click', '#backButton', function() {
                window.history.back();
            });
    
            // Clear skip input when Next button is clicked
            $(document).on('click', '#nextButton', function(event) {
                event.preventDefault();
                $('#skipInput').val('');
    
                // Validate based on question type
                let questionType = "{{ $question->type }}";
                let isValid = false;
    
                if (questionType === 'yes_no') {
                    isValid = $("#selectedAnswer").val() !== '';
                } else if (questionType === 'multiple_choice') {
                    isValid = $("#selectedAnswer").val() !== '';
                } else if (questionType === 'text') {
                    isValid = $("#textAnswer").val().trim() !== '';
                    $("#selectedAnswer").val($("#textAnswer").val().trim());
                }
    
                if (!isValid) {
                    alert('Please provide an answer before proceeding.');
                } else {
                    $('#questionForm').submit();
                }
            });
        });
    </script>
@endsection
