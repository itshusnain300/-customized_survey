@extends('admin.layouts.app')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Vendor / Update</li>
            </ol>
        </nav>
    </div>

    <section>
        <div class="container">
            <h5 class="card-title">Update Vendor</h5>
            <form method="POST" action="{{ route('admin.vendor.update', $vendor->id) }}" 
                  class="d-flex flex-column flex-grow-1 justify-content-between">
                @csrf
                @method('PUT') <!-- This allows for a PUT or PATCH request -->
                
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
                        <label for="title" class="form-label">Vendor Title</label>
                        <input type="text" class="form-control" name="title" id="title"
                               placeholder="Enter your vendor title" 
                               value="{{ old('title', $vendor->title) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" name="type" id="questionType">
                            <option value="" selected>select vendor type</option>
                            <option value="basic_set" {{ $vendor->type == 'basic_set' ? 'selected' : '' }}>Basic Set</option>
                            <option value="advanced_set" {{ $vendor->type == 'advanced_set' ? 'selected' : '' }}>Advanced Set </option>
                            <option value="customer_specific" {{ $vendor->type == 'customer_specific' ? 'selected' : '' }}>Customer Specific</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12 mt-3">
                        <label for="description" class="form-label">Vendor Description</label>
                        <textarea id="packageBenefitsTextArea" name="description" placeholder="Enter your vendor description">{{ old('description', $vendor->description) }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg d-inline-block">
                    <i class="bi bi-save-fill mr-1"></i>
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
                  'removeFormat', 'olist', 'ulist', 'code', 'line',],
        onChange: (content) => {
            console.log("Editor :", content);
        }
    });
</script>
@endsection
