@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Submitted Vendor / Index</li>
                </ol>
            </nav>
        </div>



        <section class="section">
            <div class="row">

                @foreach ($submitted_vendors as $submitted_vendor)
                    {{-- @if (!$vendor->hasSubmission(1, $vendor->id)) --}}
                        <div class="col-lg-4 mb-4">
                            <div class="card py-5">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $submitted_vendor->vendor->title }}</h5>
                                    <p>{!! $submitted_vendor->vendor->description !!}</p>
                                    <div class="d-flex justify-between gap-3">
                                        <a href="{{ route('admin.user.submitted_vendor.show',['user' => 
                                        $userId, 'vendor_submittion' => $submitted_vendor->id] ) }}" class="btn-sm btn-primary"
                                            onclick="">Show Report</a>
                                        <a href="{{ route('admin.user.submitted_vendor.show_diagram',['user' => 
                                        $userId, 'vendor_submittion' => $submitted_vendor->id] ) }}" class="btn-sm btn-primary"
                                            onclick="">Show Diagram</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- @endif --}}
                @endforeach
            </div>
        </section>


    </main>
@endsection