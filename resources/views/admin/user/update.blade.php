@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Question / Edit</li>
                </ol>
            </nav>
        </div>
        <section>
            <div class="container">
                <h5 class="card-title">Update User</h5>
                <form method="POST" action="{{ route('admin.user.update', $user->id) }}"
                      class="d-flex flex-column flex-grow-1 justify-content-between">
                    @csrf
                    @method('PUT') <!-- Use PUT or PATCH for update -->
                    
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
                            <label for="name" class="form-label">User Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                   placeholder="Enter your user name" value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" name="type" id="userType">
                                <option value="" selected>select user type</option>
                                <option value="user" {{ $user->type == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="Enter your user email" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                   placeholder="Enter new password (leave blank if you don't want to change)">
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Password Confirmation</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                                   placeholder="Confirm new password (leave blank if you don't want to change)">
                        </div>
                    </div>
        
                    <button type="submit" class="btn btn-primary btn-lg d-inline-block">
                        <i class="bi bi-save-fill mr-1"></i>
                        Update
                    </button>
        
                </form>
            </div>
        </section>
        
    </main>
@endsection
