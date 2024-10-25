@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Vednor / Create</li>
                </ol>
            </nav>
        </div>

        <section>
            <div class="container">
                <h5 class="card-title">Create New Vendor</h5>
                <form method="POST" action="{{ route('admin.vendor.store') }}" 
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
                            <label for="title" class="form-label">Vendor Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="Enter your vendor title" value="{{ old('title') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" name="type" id="questionType">
                                <option value="" selected>select vendor type</option>
                                <option value="basic_set">Basic Set</option>
                                <option value="advanced_set">Advanced Set </option>
                                <option value="customer_specific">Customer Specific</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12 mt-3">
                            <label for="benefits" class="form-label">Vendor Description</label>
                            <textarea id="packageBenefitsTextArea" name="description" placeholder="Enter your vendor description">
                                {{ old('description') }}
                            </textarea>
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
    </script>
@endsection