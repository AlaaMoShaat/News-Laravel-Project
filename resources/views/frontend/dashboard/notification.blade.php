@extends('layouts.frontend.app')
@section('title')
    Notifications
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a>Notifications</a>
    </li>
@endsection
@section('body')
    <!-- Dashboard Start-->
    <div class="dashboard container">
        <!-- Sidebar -->
        @include('frontend.dashboard._sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mb-4">Notifications</h2>
                    </div>
                    <form action="{{ route('frontend.dashboard.notifications.deleteAll') }}" method="POST" class="col-6">
                        @csrf
                        @if (auth()->user()->notifications()->count() > 0)
                            <button type="submit" class="btn btn-sm btn-danger" style="float: right">Delete All</button>
                        @endif

                    </form>
                </div>
                @forelse (auth()->user()->notifications as $notify)
                    <a href="{{ route('frontend.post.show', $notify->data['post_slug']) }}?notify={{ $notify->id }}">
                        <div class="notification alert alert-info">
                            <strong>You have a notification from: {{ $notify->data['user_name'] }}</strong> Post
                            Title: {{ $notify->data['post_title'] }}<br>
                            {{ $notify->created_at->diffForHumans() }}
                            <form action="{{ route('frontend.dashboard.notifications.delete') }}" method="POST"
                                class="float-right">
                                @csrf
                                <input hidden name="notify_id" value="{{ $notify->id }}">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </a>
                @empty
                    <div class="alert alert-danger">No Notifications</div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Dashboard End-->
@endsection
