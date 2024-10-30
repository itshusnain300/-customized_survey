@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Vendor / Index</li>
                </ol>
            </nav>
        </div>


        <section class="section">
            <div class="row">
                <div class="">

                    <div class="card">
                        <div class="card-body" style="overflow-x: scroll;">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Questionnaire Data</h5>

                                <a href="{{ route('admin.vendor.create') }}">
                                    <button class="btn btn-primary btn-lg">
                                        <i class="bi bi-plus-circle-fill mr-1"></i>
                                        Create New Questionnaire
                                    </button>
                                </a>

                            </div>
                            <!-- Table with stripped rows -->
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><b>T</b>itle</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($vendors as $vendor)
                                        <tr>
                                            <td>{{ $vendor->title }}</td>
                                            <td>{!! $vendor->description  !!}</td>
                                            <td>{{ $vendor->created_at }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.vendor.show', $vendor->id) }}">View</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.vendor.edit', $vendor->id) }}">Update</a>
                                                        <div class="dropdown-divider"></div>
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
                                                                        action="{{ route('admin.vendor.destroy', $vendor->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Delete
                                                                            Admin User
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
                                            <td colspan="4" class="text-center">No vendor found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-center">
                                {{ $vendors->links() }}
                            </div>

                        </div>
                    </div>

                </div>
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