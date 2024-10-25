@extends('admin.layouts.app')
@section('main')

@php
    $options = $question->options;
@endphp
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.question.index') }}">Questions</a></li>
                    <li class="breadcrumb-item active">Show Question</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Question Details</h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Question Title</label>
                                <p class="form-control-plaintext">{{ $question->title }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Type</label>
                                <p class="form-control-plaintext">{{ ucfirst(str_replace('_', ' ', $question->type)) }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Vendor</label>
                                <p class="form-control-plaintext">{{ $question->vendor->title ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Options (only for multiple choice questions) -->
                        @if($question->type === 'multiple_choice')
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Options</label>
                                <ul class="list-group">
                                    @foreach($options as $option)
                                        <li class="list-group-item">{{ $option->title }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.question.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left-circle-fill"></i> Back to Questions
                            </a>

                            <div class="d-flex">
                                <a href="{{ route('admin.question.edit', $question->id) }}" class="btn btn-warning me-2">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                                
                                <form action="{{ route('admin.question.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash-fill"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
