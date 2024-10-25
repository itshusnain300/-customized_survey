@extends('admin.layouts.app')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Notifications</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Notifications</li>
            </ol>
        </nav>
    </div>


    <section class="section">
        <div class="row">

            <div class="col-lg-12 ">
                <div>
                    
                    <ul class="list-group">
                        @foreach ($notifications as $notification)
                            <li class="list-group-item notification-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <div>
                                        <h4 class="mb-1">{{ $notification->data['subject'] ?? 'No Subject' }}</h4>
                                        <p class="mb-0">Name: {{ $notification->data['name'] }}</p>
                                        <p class="mb-0">Email: {{ $notification->data['email'] }}</p>
                                    </div>
                                </div>
                                <div>
                                    @if (!empty($notification->data['link']))
                                        <a href="{{ $notification->data['link'] }}" class="view-icon btn btn-outline-primary me-2">
                                            <i class="bi bi-eye"></i> View Details
                                        </a>
                                        
                                    @endif
                                    @if (!$notification->read_at)
                                        <form action="{{ route('admin.notifications.markAsRead', $notification->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-secondary">
                                                Mark as Read
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-success">Read</span>
                                    @endif
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </section>

</main>

@endsection

