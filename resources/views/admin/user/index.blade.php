@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">User / Index</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="">

                    <div class="card">
                        <div class="card-body" style="overflow-x: scroll;">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Users Data</h5>

                                <a href="{{ route('admin.user.create') }}">
                                    <button class="btn btn-primary btn-lg">
                                        <i class="bi bi-plus-circle-fill mr-1"></i>
                                        Create New User
                                    </button>
                                </a>

                            </div>
                            <!-- Table with stripped rows -->
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><b>N</b>ame</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Active</th>
                                        <th>Company</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->type }}</td>

                                            <td style="text-align: center;">
                                                <div class=" form-check form-switch d-flex justify-content-center">

                                                    <form id="student-active-form{{ $user->id }}" method="POST"
                                                        action="{{ route('admin.user.active.update', $user->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input name="active" class="form-check-input" type="checkbox"
                                                            role="switch" onchange="activeStudent({{ $user->id }})"
                                                            {{ $user->active == 1 ? 'checked' : '' }}>
                                                    </form>

                                                </div>
                                            </td>

                                            <td>
                                                <span class="badge {{ $user->userCompany && $user->userCompany->company ? 'bg-primary' : 'bg-warning' }}">
                                                    {{ $user->userCompany && $user->userCompany->company ? $user->userCompany->company->name : 'No Associated Company' }}
                                                </span>
                                            </td>
                                            
                                            <td>{{ $user->created_at }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.user.show', $user->id) }}">View</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.user.edit', $user->id) }}">Update</a>
                                                        <div class="dropdown-divider"></div>

                                                        @if ($user->hasSubmission($user->id))
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.user.submitted_vendors', $user->id) }}">Submitted
                                                                Vendors</a>
                                                            <div class="dropdown-divider"></div>
                                                        @endif
                                                        <button type="button" class="dropdown-item btn btn-danger block"
                                                            data-toggle="modal" data-target="#deleteInstructorModal">
                                                            Delete
                                                        </button>
                                                    </div>

                                                    {{-- // Delete Modal // --}}
                                                    <div class="modal fade" id="deleteInstructorModal" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Modal
                                                                        title</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h5 class="card-title">Are you sure to delete this.</h5>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <form
                                                                        action="{{ route('admin.user.destroy', $user->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Delete
                                                                            User
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No user found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-center">
                                {{ $users->links() }}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('script')
    <script>
        function activeStudent(studentId) {
            $('#student-active-form' + studentId).submit();
        };
    </script>
@endsection
