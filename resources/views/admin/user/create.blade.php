@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">User / Create</li>
                </ol>
            </nav>
        </div>

        <section>
            <div class="container">
                <div class="card p-4">
                    <h5 class="card-title">Create New User</h5>
                    <form method="POST" action="{{ route('admin.user.store') }}"
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
                                <label for="title" class="form-label">User Name</label>
                                <input type="text" class="form-control" name="name" id="title"
                                    placeholder="Enter your user name" value="{{ old('name') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-select" name="type" id="userType">
                                    <option value="" selected>select user type</option>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                    <option value="customer">Customer</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="title" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="title"
                                    placeholder="Enter your user email" value="{{ old('email') }}">
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="title"
                                    placeholder="Enter password" value="{{ old('password') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="title" class="form-label">Password Confirmation</label>
                                <input type="password" class="form-control" name="password_confirmation" id="title"
                                    placeholder="Enter password" value="{{ old('password_confirmation') }}">
                            </div>
                        </div>

                        {{-- Company Assignment Section --}}
                        {{-- <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="company_id" class="form-label">Assign Company</label>
                                <select class="form-select" name="company_id" id="company_id">
                                    <option value="" selected>Select company for user</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
                         --}}

                        <button type="submit" class="btn btn-primary btn-lg d-inline-block">
                            <i class="bi bi-plus-circle-fill mr-1"></i>
                            Create
                        </button>
    
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
