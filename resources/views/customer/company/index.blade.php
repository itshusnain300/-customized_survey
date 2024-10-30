@extends('customer.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Company / Index</li>
                </ol>
            </nav>
        </div>



        <section class="section">
            <div class="row">

                @foreach ($companies as $company)
                    @if (!$company->hasSubmission(auth()->id(), $company->id))
                        <div class="col-lg-4 mb-4">
                            <div class="card py-5">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $company->name }}</h5>
                                    <p>{!! $company->description !!}</p>
                                    <a href="{{ route('customer.company.vendors', $company->id) }}" class="btn btn-primary"
                                        onclick="toggleQuestions('vendor1Questions')">Go Forward</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>


    </main>
@endsection
