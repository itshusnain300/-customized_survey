@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Question / Edit</li>
                </ol>
            </nav>
        </div>

        <section>
            <div class="container">
                <h5 class="card-title">Edit Question</h5>
                <form method="POST" action="{{ route('admin.question.update', $question->id) }}"
                    class="d-flex flex-column flex-grow-1 justify-content-between">
                    @csrf
                    @method('PUT') <!-- Use PUT method for updating -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Question Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="Enter your question title" value="{{ old('title', $question->title) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" name="type" id="questionType">
                                <option value="" disabled>select question type</option>
                                <option value="multiple_choice"
                                    {{ $question->type == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="yes_no" {{ $question->type == 'yes_no' ? 'selected' : '' }}>Yes/No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Options container, initially hidden if not multiple choice -->
                    <div id="optionsContainer" class="mb-3"
                        style="display: {{ $question->type == 'multiple_choice' ? 'block' : 'none' }};">
                        <label for="options" class="form-label">Options</label>
                        <div id="optionsWrapper">
                            @if ($question->type == 'multiple_choice')
                                @foreach ($question->options as $option)
                                    <div class="input-group mb-2 option-item">
                                        <input type="text" name="options[]" class="form-control"
                                            placeholder="Enter option" value="{{ $option->title }}">
                                        <button class="btn btn-outline-success add-option" type="button">+</button>
                                        <button class="btn btn-outline-danger remove-option" type="button">-</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2 option-item">
                                    <input type="text" name="options[]" class="form-control" placeholder="Enter option">
                                    <button class="btn btn-outline-success add-option" type="button">+</button>
                                    <button class="btn btn-outline-danger remove-option" type="button">-</button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="vendor" class="form-label">Select Vendor</label>
                            <select class="form-select" name="vendor_id" aria-label="Default select example">
                                <option value="" disabled>select vendor for which you want to create a question
                                </option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                        {{ $question->vendor_id == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12 mt-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" name="category" id="category"
                                placeholder="Enter your question's category" value="{{ old('category', $question->category ?? '') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12 mt-3">
                            <label for="benefits" class="form-label">Question Description</label>
                            <textarea id="packageBenefitsTextArea" name="description" placeholder="Enter your question description">
                                {{ old('description', $question->description ?? '') }}
                            </textarea>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary btn-lg d-inline-block">
                        <i class="bi bi-save mr-1"></i>
                        Update
                    </button>
                </form>
            </div>
        </section>
    </main>
@endsection

@section('script')
    <script>
        const tex = window.tex;

        tex.init({
            element: document.getElementById("packageBenefitsTextArea"),
            buttons: ['bold', 'italic', 'underline', 'textColor', 'heading1', 'heading2', 'paragraph',
                'removeFormat', 'olist', 'ulist', 'code', 'line',
            ],
            onChange: (content) => {
                console.log("Editor :", content);
            }
        });

        $(document).ready(function() {

            // Show or hide options based on selected question type
            $('#questionType').on('change', function() {
                var selectedType = $(this).val();
                if (selectedType === 'multiple_choice') {
                    $('#optionsContainer').show();
                } else {
                    $('#optionsContainer').hide();
                    $('#optionsWrapper').empty(); // Clear options if another type is selected
                    addOption(); // Add one default option
                }
            });

            // Add a new option field
            function addOption() {
                var optionHtml = `
                    <div class="input-group mb-2 option-item">
                        <input type="text" name="options[]" class="form-control" placeholder="Enter option">
                        <button class="btn btn-outline-success add-option" type="button">+</button>
                        <button class="btn btn-outline-danger remove-option" type="button">-</button>
                    </div>`;
                $('#optionsWrapper').append(optionHtml);
            }

            // Add option when clicking the "+" button
            $(document).on('click', '.add-option', function() {
                addOption();
            });

            // Remove option when clicking the "-" button
            $(document).on('click', '.remove-option', function() {
                $(this).closest('.option-item').remove();
            });

            // Add one option on page load if no options exist
            @if ($question->type != 'multiple_choice' || $question->options->isEmpty())
                addOption();
            @endif
        });
    </script>
@endsection
