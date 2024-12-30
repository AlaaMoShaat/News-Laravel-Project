@extends('layouts.frontend.app')
@section('title')
    Show {{ $mainPost->title }}
@endsection
@section('meta_desc')
    {{ $mainPost->small_desc }}
@endsection
@push('header')
    <link rel="canonical" href="{{ url()->full() }}">
@endpush
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item "><a
            href="{{ route('frontend.category.posts', $mainPost->category->slug) }}">{{ $mainPost->category->name }}</a>
    <li class="breadcrumb-item active"><a>{{ $mainPost->title }}</a>
    </li>
@endsection
@section('body')
    <!-- Single News Start-->
    <div class="single-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Carousel -->
                    <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#newsCarousel" data-slide-to="1"></li>
                            <li data-target="#newsCarousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($mainPost->images as $image)
                                <div class="carousel-item @if ($loop->index == 0) active @endif">
                                    <img width="690px" height="420px"
                                        src="{{ $image ? asset($image->path) : asset('default.jpg') }}"
                                        class="d-block w-100" alt="First Slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $mainPost->title }}</h5>
                                        <p>
                                            {!! Str::substr($mainPost->desc, 0, 80) !!}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Add more carousel-item blocks for additional slides -->
                        </div>

                    </div>
                    <div style="width: 50%" class="alert alert-info">
                        Publisher: {{ $mainPost->user->name ?? $mainPost->admin->name }}
                    </div>
                    <div class="sn-content">
                        {!! $mainPost->desc !!}
                    </div>

                    <!-- Comment Section -->

                    @auth
                        @if (auth('web')->user()->status != 0)
                            <div class="comment-section">
                                @if ($mainPost->comment_able)
                                    <!-- Comment Input -->
                                    <form id="commentForm" action="">
                                        <div class="comment-input">
                                            @csrf
                                            <input name="comment" type="text" placeholder="Add a comment..."
                                                id="commentBox" />
                                            <button type="submit" id="addCommentBtn">Comment</button>
                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                            <input type="hidden" name="post_id" value="{{ $mainPost->id }}">
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-info">
                                        Unable to Comment
                                    </div>
                                @endif
                                <div style="display: none" class="alert alert-danger" id="error-comment-msg">

                                </div>
                                <!-- Display Comments -->
                                <div class="comments">
                                    @foreach ($mainPost->comments as $comment)
                                        <div class="comment">
                                            <img src="{{ $comment->user->image ? asset($comment->user->image) : asset('default.jpg') }}"
                                                alt="User Image" class="comment-img" />
                                            <div class="comment-content">
                                                <span
                                                    class="username">{{ $comment->user->name ?? $comment->admin->name }}</span>
                                                <p class="comment-text">{{ $comment->comment }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!-- Add more comments here for demonstration -->
                                </div>

                                <!-- Show More Button -->
                                @if ($mainPost->comments->count() > 2)
                                    <button id="showMoreBtn" class="show-more-btn">Show more</button>
                                @endif
                            </div>
                        @endif
                    @endauth



                    <!-- Related News -->
                    <div class="sn-related">
                        <h2>Related News</h2>
                        <div class="row sn-slider">
                            @foreach ($posts_belongs_to_category as $post)
                                <div class="col-md-4">
                                    <div class="sn-img">
                                        <img width="260px" height="210px" height="px"
                                            src="{{ $post->images->first() ? asset($post->images->first()->path) : asset('default.jpg') }}"
                                            alt="{{ $post->title }}" class="img-fluid" alt="Related News 1" />
                                        <div class="sn-title">
                                            <a href="{{ route('frontend.post.show', $post->slug) }}"
                                                title="{{ $post->title }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="sidebar-widget">
                            <h2 class="sw-title">In This Category</h2>
                            <div class="news-list">
                                @foreach ($posts_belongs_to_category as $post)
                                    <div class="nl-item">
                                        <div class="nl-img">
                                            <img width="100px" height="75px"
                                                src="{{ $post->images->first() ? asset($post->images->first()->path) : asset('default.jpg') }}" />
                                        </div>
                                        <div class="nl-title">
                                            <a
                                                href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <div class="sidebar-widget">
                            <div class="tab-news">
                                <ul class="nav nav-pills nav-justified">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#popular">Popular</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#latest">Latest</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="popular" class="container tab-pane active">
                                        @foreach ($popular_posts as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img width="100px" height="75px"
                                                        src="{{ $post->images->first() ? asset($post->images->first()->path) : asset('default.jpg') }}"
                                                        alt="{{ $post->title }}" />
                                                </div>
                                                <div class="tn-title">
                                                    <a href="{{ route('frontend.post.show', $post->slug) }}"
                                                        title="{{ $post->title }}">{{ $post->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                    <div id="latest" class="container tab-pane fade">
                                        @foreach ($latest_posts as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img width="100px" height="75px"
                                                        src="{{ $post->images->first() ? asset($post->images->first()->path) : asset('default.jpg') }}"
                                                        alt="{{ $post->title }}" />
                                                </div>
                                                <div class="tn-title">
                                                    <a href="{{ route('frontend.post.show', $post->slug) }}"
                                                        title="{{ $post->title }}">{{ $post->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <h2 class="sw-title">News Category</h2>
                            <div class="category">
                                <ul>
                                    @foreach ($categories as $category)
                                        <li><a href="{{ route('frontend.category.posts', $category->slug) }}"
                                                title="{{ $category->name }}">{{ $category->name }}</a><span>({{ $category->posts->count() }}
                                                News)</span>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>


                        <div class="sidebar-widget">
                            <h2 class="sw-title">Tags Cloud</h2>
                            <div class="tags">
                                <a href="">National</a>
                                <a href="">International</a>
                                <a href="">Economics</a>
                                <a href="">Politics</a>
                                <a href="">Lifestyle</a>
                                <a href="">Technology</a>
                                <a href="">Trades</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single News End-->

    <style>
        .sn-related {
            position: relative;
        }

        .sn-slider.slick-initialized .slick-prev.slick-arrow,
        .sn-slider.slick-initialized .slick-next.slick-arrow {
            top: 20px;
        }
    </style>
@endsection

@push('js')
    <script>
        $(document).on('click', '#showMoreBtn', function(e) {
            e.preventDefault();
            $('#showMoreBtn').hide();
            $.ajax({
                url: "{{ route('frontend.post.getAllComments', $mainPost->slug) }}",
                type: 'GET',

                success: function(data) {
                    $('.comments').empty();

                    $.each(data, function(key, comment) {
                        const userImage = "{{ asset('') }}" + comment.user.image;
                        const createdAt = new Date(comment.created_at);
                        const now = new Date();
                        const timeDifference = calculateTimeDifference(createdAt, now);
                        $('.comments').prepend(`
                            <div class="comment">
                                <img src="${userImage}" alt="User Image" class="comment-img" />
                                <div class="comment-content">
                                    <span class="username">${comment.user.name}</span>
                                    <p class="comment-text">${comment.comment}</p>
                                    <p class="comment-time" style="float: right">${ timeDifference }</p>
                                </div>
                            </div>
                        `);
                    });
                },

                error: function(data) {

                }
            });
        });


        $(document).on('submit', '#commentForm', function(e) {
            e.preventDefault();

            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "{{ route('frontend.post.comment.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    const userImage = "{{ asset('') }}" + data.comment.user.image;
                    $('#commentBox').val('');
                    $('.comments').prepend(`
                            <div class="comment">
                                <img src="${userImage}" alt="User Image" class="comment-img" />
                                <div class="comment-content">
                                    <span class="username">${data.comment.user.name}</span>
                                    <p class="comment-text">${data.comment.comment}</p>
                                </div>
                            </div>
                        `);
                    $('#error-comment-msg').hide();
                },

                error: function(data) {
                    var response = $.parseJSON(data.responseText);
                    $('#error-comment-msg').text(response.errors.comment).show();
                }
            });
        });

        function calculateTimeDifference(start, end) {
            const diffInSeconds = Math.floor((end - start) / 1000);

            if (diffInSeconds < 60) return `${diffInSeconds} seconds ago`;
            const diffInMinutes = Math.floor(diffInSeconds / 60);
            if (diffInMinutes < 60) return `${diffInMinutes} minutes ago`;
            const diffInHours = Math.floor(diffInMinutes / 60);
            if (diffInHours < 24) return `${diffInHours} hours ago`;
            const diffInDays = Math.floor(diffInHours / 24);
            if (diffInDays < 30) return `${diffInDays} days ago`;
            const diffInMonths = Math.floor(diffInDays / 30);
            if (diffInMonths < 12) return `${diffInMonths} months ago`;
            const diffInYears = Math.floor(diffInMonths / 12);
            return `${diffInYears} years ago`;
        }
    </script>
@endpush
