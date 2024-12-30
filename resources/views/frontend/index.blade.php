@extends('layouts.frontend.app')
@section('title')
    Home
@endsection
@section('breadcrumb')
    @parent
@endsection
@section('meta_desc')
    {{ $get_setting->small_desc }}
@endsection
@push('header')
    <link rel="canonical" href="{{ url()->full() }}">
@endpush
@section('body')
    @php
        $latest_three_posts = $posts->take(3);
    @endphp
    <!-- Top News Start-->
    <div class="top-news">
        <div class="container">
            <div class="row">
                <div class="col-md-6 tn-left">
                    <div class="row tn-slider">
                        @foreach ($latest_three_posts as $post)
                            <div class="col-md-6">
                                <div class="tn-img">
                                    <img style="height: 400px; width: 540px;"
                                        src="{{ $post->images->first() ? asset($post->images->first()->path) : asset('default.jpg') }}" />
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 tn-right">
                    @php
                        $latest_four_posts = $posts->take(4);
                    @endphp
                    <div class="row">
                        @foreach ($latest_four_posts as $post)
                            <div class="col-md-6">
                                <div class="tn-img">
                                    <img style="width: 280px; height: 165px;"
                                        src="{{ $post->images->first() ? asset($post->images->first()->path) : asset('default.jpg') }}" />
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top News End-->

    <!-- Category News Start-->
    <div class="cat-news">
        <div class="container">
            <div class="row">
                @foreach ($categories_with_posts as $cat)
                    <div class="col-md-6">
                        <h2><a href="{{ route('frontend.category.posts', $cat->slug) }}">{{ $cat->name }}</a></h2>
                        <div class="row cn-slider">
                            @foreach ($cat->posts as $post)
                                <div class="col-md-6">
                                    <div class="cn-img">
                                        <img width="260px" height="210px"
                                            src="{{ $post->images->first() ? asset($post->images->first()->path) : asset('default.jpg') }}" />
                                        <div class="cn-title">
                                            <a
                                                href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Category News End-->


    <!-- Tab News Start-->
    <div class="tab-news">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#featured">Oldest News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#popular">Popular News</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="featured" class="container tab-pane active">
                            @foreach ($oldest_posts as $post)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img width="150px" height="115px"
                                            src="{{ $post->images->first() ? asset($post->images->first()->path) : asset('default.jpg') }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="popular" class="container tab-pane fade">
                            @foreach ($popular_posts as $post)
                                <div class="tn-news mr">
                                    <span>{{ $post->comments_count }} <i class="fa fa-comment"></i></span>
                                    <div class="tn-img">
                                        <img width="150px" height="115px"
                                            src="{{ $post->images->first() ? asset($post->images->first()->path) : asset('default.jpg') }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#m-viewed">Latest News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#m-read">Most Read</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        {{-- Latest News Content  --}}
                        <div id="m-viewed" class="container tab-pane active">
                            @foreach ($latest_three_posts as $post)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img width="150px" height="115px"
                                            src="{{ $post->images->first() ? asset($post->images->first()->path) : asset('default.jpg') }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div id="m-read" class="container tab-pane fade">
                            @foreach ($gretest_posts_views as $post)
                                <div class="tn-news mr">
                                    <span>{{ $post->num_of_views }} <i class="fa fa-eye"></i></span>
                                    <div class="tn-img">
                                        <img width="150px" height="115px"
                                            src="{{ $post->images->first() ? asset($post->images->first()->path) : asset('default.jpg') }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab News Start-->

    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img style="width: 260px; height: 210px;"
                                        src="{{ $post->images->first() ? asset($post->images->first()->path) : asset('default.jpg') }}" />
                                    <div class="mn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $posts->links() }}
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2>Read More</h2>
                        <ul>
                            @foreach ($read_more_posts as $post)
                                <li><a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End-->


    <style>
        .tab-news .tn-news.mr {
            position: relative;
        }

        .tab-news .tn-news.mr span {
            position: absolute;
            right: -20px;
            top: -5px;
            border-radius: 4px;
            background-color: #ff6f61;
            align-items: center;
            text-align: center;
            color: white;
            width: 120px;
            height: 30px;
            line-height: 30px;
        }
    </style>
@endsection
