@extends('layouts.dashboard.app')
@section('title')
    Show Post
@endsection

@section('body')
    <div class="d-flex justify-content-center">
        <div class="card-body shadow mb-4" style="max-width: 100ch">
            <a class="btn btn-primary" href="{{ route('dashboard.posts.index', ['page' => request()->page]) }}">Back To
                Posts</a>
            <br><br>
            <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#newsCarousel" data-slide-to="1"></li>
                    <li data-target="#newsCarousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" style="height: 70ch">
                    @foreach ($post->images as $index => $image)
                        <div class="carousel-item @if ($index == 0) active @endif">
                            <img src="{{ asset($image->path) }}" class="d-block w-100" alt="First Slide">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>{{ $post->title }}</h5>
                                <p>

                                </p>
                            </div>
                        </div>
                    @endforeach

                    <!-- Add more carousel-item blocks for additional slides -->
                </div>
                <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <br>
            <div class="row">
                <div class="col-4">
                    <h6>
                        Publisher : {{ $post->user->name ?? $post->admin->name }} <i class="fa fa-user"></i>
                    </h6>
                </div>
                <div class="col-4">
                    <h6>
                        Views : {{ $post->num_of_views }} <i class="fa fa-eye"></i>
                    </h6>
                </div>
                <div class="col-4">
                    <h6>
                        Created At : {{ $post->created_at->format('Y-m-d h:m') }} <i class="fa fa-edit"></i>
                    </h6>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <h6>
                        Comments : {{ $post->comment_able == 1 ? 'Active' : 'Not Active' }} <i class="fa fa-comment"></i>
                    </h6>
                </div>
                <div class="col-4">
                    <h6>
                        Status : {{ $post->status == 1 ? 'Active' : 'Not Active' }} <i
                            class="fa @if ($post->status == 0) fa-plane @else fa-wifi @endif "></i>
                    </h6>
                </div>
                <div class="col-4">
                    <h6>
                        Category : {{ $post->category->name }} <i class="fa fa-folder"></i>
                    </h6>
                </div>
            </div>
            <br>
            <div class="sn-content">
                <strong>Small Description : {!! $post->small_desc !!}</strong>
            </div>
            <br>
            <div class="sn-content">
                {!! $post->desc !!}
            </div>

            <br>
            <center>
                <a class="btn btn-danger" href="javascript:void(0)"
                    onclick="if(confirm('Do you want to delete the post')){document.getElementById('delete_post_{{ $post->id }}').submit()} return false">Delete
                    Post <i class="fa fa-trash"></i></a>
                <a class="btn btn-primary" href="{{ route('dashboard.posts.changeStatus', $post->id) }}">Change Status <i
                        class="fa @if ($post->status == 1) fa-stop @else fa-play @endif"></i></a>
                <a class="btn btn-info" href="{{ route('dashboard.posts.edit', $post->id) }}">Edit Post <i
                        class="fa fa-edit"></i></a>
            </center>
        </div>
    </div>
    <form id="delete_post_{{ $post->id }}"
        action="{{ route('dashboard.posts.destroy', ['post' => $post->id, 'page' => request()->page]) }}" method="post">
        @csrf
        @method('DELETE')
    </form>



    {{-- show comments --}}
    <div class="d-flex justify-content-center">

        <!-- Main Content -->
        <div class="card-body shadow mb-4" style="max-width: 100ch">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mb-4">Comments</h2>
                    </div>

                </div>
                @forelse ($post->comments as $comment)
                    <div class="notification alert alert-info comment-row" id="comment-{{ $comment->id }}">
                        <strong><img src="{{ asset($comment->user->image) }}" width="50px" class="img-thumbnial rounded">
                            <a style="text-decoration: none"
                                href="{{ route('dashboard.users.show', $comment->user->id) }}">{{ $comment->user->name }}</a>
                            : </strong> {{ $comment->comment }}.<br>
                        <strong style="color: red"> {{ $comment->created_at->diffForHumans() }}</strong>
                        <div class="float-right">
                            <!-- حذف التعليق -->
                            <button class="btn btn-danger btn-sm delete-comment"
                                data-id="{{ $comment->id }}">Delete</button>

                            <!-- تغيير حالة التعليق -->
                            <button class="btn {{ $comment->status ? 'btn-danger' : 'btn-info' }} btn-sm toggle-status"
                                data-status_id="{{ $comment->id }}">
                                {{ $comment->status ? 'Deactivate it' : 'Activate it' }}
                            </button>

                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        No Comments yet!
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Delete comment
            $(document).on('click', '.delete-comment', function() {
                const commentId = $(this).data('id');

                $.ajax({
                    url: `comment/delete/${commentId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $(`#comment-${commentId}`).remove();
                    },
                    error: function(xhr) {
                        alert('An error occurred while deleting the comment.');
                    }
                });
            });


            // Change comment status
            $(document).on('click', '.toggle-status', function() {
                const commentId = $(this).data('status_id');

                $.ajax({
                    url: `comment/status/${commentId}`,
                    type: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // CSRF protection
                    },
                    success: function(response) {
                        const button = $(`button[data-status_id="${commentId}"]`);
                        button.toggleClass('btn-danger btn-info');
                        button.text(response.newStatus ? 'Deactivate it' : 'Activate it');
                    },
                    error: function(xhr) {
                        alert('An error occurred while updating the comment status.');
                    }
                });
            });
        });
    </script>
@endpush