@extends('layouts.frontend.app')
@section('title')
    {{ $category_slug->name }} Category
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a>{{ $category_slug->name }}</a>
    </li>
@endsection
@push('header')
    <link rel="canonical" href="{{ url()->full() }}">
@endpush
@section('body')
    <br><br>
    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        @forelse ($posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img width="260px" height="210px" src="{{ asset($post->images->first()->path) }}" />
                                    <div class="mn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}"
                                            title="{{ $post->title }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-lg-12 alert-info">
                                Category is Embty
                            </div>
                        @endforelse
                    </div>
                    {{ $posts->links() }}
                </div>

                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2>Other Categories</h2>
                        <ul>
                            @foreach ($categories as $category)
                                @if ($category->id != $category_slug->id)
                                    <li>
                                        <a
                                            href="{{ route('frontend.category.posts', $category->slug) }}">{{ $category->name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End-->
@endsection
