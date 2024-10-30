@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Company / Update</li>
                </ol>
            </nav>
        </div>

        <section>
            <div class="container">
                <h5 class="card-title">Update Vendor</h5>
                <form method="POST" action="{{ route('admin.company.update', $company->id) }}"
                    class="d-flex flex-column flex-grow-1 justify-content-between">
                    @csrf
                    @method('PUT')
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
                            <label for="name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter your company name" value="{{ old('name', $company->name) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="description" class="form-label">Company Description</label>
                            <input type="text" class="form-control" name="description" id="description"
                                placeholder="Enter your company description" value="{{ old('description', $company->description) }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="basic_set" class="form-label">Basic Set</label>
                            <select class="form-select" name="basic_set">
                                <option value="" selected>Select company basic set</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ $company->basic_set == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="advanced_set" class="form-label">Advanced Set</label>
                            <select class="form-select" name="advanced_set">
                                <option value="" selected>Select company advanced set</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ $company->advanced_set == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="customer_specific" class="form-label">Customer Specific Set</label>
                            <select class="form-select" name="customer_specific">
                                <option value="" selected>Select company customer specific set</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ $company->customer_specific == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg d-inline-block">
                        <i class="bi bi-pencil-square mr-1"></i>
                        Update
                    </button>
                </form>
            </div>
        </section>
    </main>
@endsection
