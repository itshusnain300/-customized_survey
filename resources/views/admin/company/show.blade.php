@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Company / Details</li>
                </ol>
            </nav>
        </div>

        <section>
            <div class="container">
                <h5 class="card-title">Company Details</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Company Name:</strong>
                                <p>{{ $company->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Company Description:</strong>
                                <p>{{ $company->description }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Basic Set:</strong>
                                <p>{{ optional($company->basicSet)->title ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Advanced Set:</strong>
                                <p>{{ optional($company->advancedSet)->title ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Customer Specific Set:</strong>
                                <p>{{ optional($company->customerSpecific)->title ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <a href="{{ route('admin.company.edit', $company->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil-square mr-1"></i> Edit Company
                        </a>
                        <a href="{{ route('admin.company.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left mr-1"></i> Back to Companies
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
