@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Company / Create</li>
                </ol>
            </nav>
        </div>

        <section>
            <div class="container">
                <h5 class="card-title">Create New Vendor</h5>
                <form method="POST" action="{{ route('admin.company.store') }}"
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
                        <div class="col-md-6">
                            <label for="title" class="form-label">Vendor Name</label>
                            <input type="text" class="form-control" name="name" id="title"
                                placeholder="Enter your company name" value="{{ old('name') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="title" class="form-label">Vendor Description</label>
                            <input type="text" class="form-control" name="description" id="title"
                                placeholder="Enter your company description" value="{{ old('description') }}">
                        </div>
                       
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Basic Set</label>
                            <select class="form-select" name="basic_set" >
                                <option value="" selected>select company basic set</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ $vendor->type == 'basic_set' ? 'selected' : '' }}>{{ $vendor->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Advanced Set</label>
                            <select class="form-select" name="advanced_set" >
                                <option value="" selected>select company advanced set</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ $vendor->type == 'advanced_set' ? 'selected' : '' }}>{{ $vendor->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Customer Specific Set</label>
                            <select class="form-select" name="customer_specific" >
                                <option value="" selected>select company customer specific set</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ $vendor->type == 'customer_specific' ? 'selected' : '' }}>{{ $vendor->title }}</option>
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

{{-- @section('script')
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
            // Show or hide options based on selected company type
            $('#companyType').on('change', function() {
                var selectedType = $(this).val();
                if (selectedType === 'multiple_choice') {
                    $('#optionsContainer').show();
                } else {
                    $('#optionsContainer').hide();
                    $('#optionsWrapper').empty(); // Clear options if other type is selected
                    addOption(); // Add one default option
                }
            });

            let optionIndex = 0; 
            // Add a new option field
            function addOption() {

                optionIndex++;

                var optionHtml = `
                <div class="input-group mb-2 option-item">
                    <input type="text" name="options[${optionIndex}][text]" class="form-control" placeholder="Enter option">
                    <input type="number" name="options[${optionIndex}][weight]" class="form-control" placeholder="Weight" min="0">
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
@endsection --}}
