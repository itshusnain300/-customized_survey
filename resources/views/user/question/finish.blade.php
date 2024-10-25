@extends('user.layouts.app')
@section('main')
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

        <section class="section">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h1>Survey Completed!</h1>
                        <p>Thank you for completing the survey for {{ $vendor->title }}.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
