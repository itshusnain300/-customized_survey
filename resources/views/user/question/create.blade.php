@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Question / Create</li>
                </ol>
            </nav>
        </div>

        <section>
            <div class="container">
                <h5 class="card-title">Create New Question</h5>
                <form method="POST" action="{{ route('admin.question.store') }}"
                    class="d-flex flex-column flex-grow-1 justify-content-between">
                    @csrf
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
                        <div class="col-md-8">
                            <label for="title" class="form-label">Question Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="Enter your question title" value="{{ old('title') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" name="type" id="questionType">
                                <option value="" selected>select question type</option>
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="yes_no">Yes/No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Options container, initially hidden -->
                    <div id="optionsContainer" class="mb-3" style="display: none;">
                        <label for="options" class="form-label">Options</label>
                        <div id="optionsWrapper">
                            <div class="input-group mb-2 option-item">
                                <input type="text" name="options[]" class="form-control" placeholder="Enter option">
                                <button class="btn btn-outline-success add-option" type="button">+</button>
                                <button class="btn btn-outline-danger remove-option" type="button">-</button>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="title" class="form-label">Select Vendor</label>
                            <select name="vendor_id" class="form-select" aria-label="Default select example">
                                <option value="" selected>select vendor for which you want to a question for</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary btn-lg d-inline-block">
                        <i class="bi bi-plus-circle-fill mr-1"></i>
                        Create
                    </button>

                </form>
            </div>
        </section>
    </main>
@endsection

@section('script')
    <script>
        
        $(document).ready(function() {
            // Show or hide options based on selected question type
            $('#questionType').on('change', function() {
                var selectedType = $(this).val();
                if (selectedType === 'multiple_choice') {
                    $('#optionsContainer').show();
                } else {
                    $('#optionsContainer').hide();
                    $('#optionsWrapper').empty(); // Clear options if other type is selected
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

            // Add one option on page load
            addOption();
        });
    </script>
@endsection
