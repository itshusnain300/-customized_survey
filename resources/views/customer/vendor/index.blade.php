@extends('customer.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Vendor / Index</li>
                </ol>
            </nav>
        </div>



        <section class="section">
            <div class="row">

                @foreach ($vendors as $vendor)
                    @if (!$vendor->hasSubmission(auth()->id(), $vendor->id))
                        <div class="col-lg-4 mb-4">
                            <div class="card py-5">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $vendor->title }}</h5>
                                    <span class="badge badge-primary p-2">
                                        {{ $submittedVendor->company->name ?? 'N/A' }}
                                    </span>
                                    <p>{!! $vendor->description !!}</p>


{{-- <div>{{ $user->id }}</div>
<div>{{ $vendor->id }}</div> --}}

                                    @if ($packageType == 'basic')
                                        <a href="{{ route('customer.user.submitted_vendor.show', ['user' => $user->id, 'vendor_submittion' => $vendor_submission->id]) }}"
                                            class="btn btn-primary">Show
                                            Report</a>
                                    @else
                                        <a href="{{ route('customer.question.show', ['company' => $company->id, 'vendor' => $vendor->id]) }}"
                                            class="btn btn-primary">Show
                                            Questions</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>


    </main>
@endsection


{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.form-check-input').on('change', function() {
        var vendorId = $(this).attr('id').replace('vendorSwitch', '');

        $('#vendorApproveForm' + vendorId).submit();
    });
});
</script> --}}
