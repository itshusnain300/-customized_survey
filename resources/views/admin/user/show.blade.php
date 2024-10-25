@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Show User</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">User Details</h5>
        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">User Name</label>
                                <p class="form-control-plaintext ">{{ $user->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Type</label>
                                <p class="form-control-plaintext ">{{ ucfirst(str_replace('_', ' ', $user->type)) }}</p>
                            </div>
                        </div>
        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <p class="form-control-plaintext ">{{ $user->email ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Password</label>
                                <p class="form-control-plaintext ">{{ $user->password }}</p>
                            </div>
                        </div>
        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Created At</label>
                                <p class="form-control-plaintext ">{{ $user->created_at ?? 'N/A' }}</p>
                            </div>
                        </div>
        
                    </div>
                </div>
            </div>
        </section>
        
    </main>
@endsection
