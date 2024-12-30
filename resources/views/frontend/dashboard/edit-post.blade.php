@extends('layouts.frontend.app')
@section('title')
    Edit: {{ $post->title }}
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a>Profile</a>
    </li>
@endsection
@section('body')
    <div class="dashboard container">
        <!-- Sidebar -->
        @include('frontend.dashboard._sidebar')

        <!-- Main Content -->
        <div class="main-content col-md-9">
            <!-- Show/Edit Post Section -->
            @if (session()->has('errors'))
                <div class="alert-danger">
                    @foreach (session('errors')->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            <!-- Example of a Post Item -->
            <form action="{{ route('frontend.dashboard.post.update') }}" method="POST" class="post-item"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <section id="posts-section" class="posts-section">
                    <h2>Edit Post</h2>
                    <ul class="list-unstyled user-posts">

                        <!-- Editable Title -->
                        <input name="title" value="{{ $post->title }}" type="text"
                            class="form-control mb-2 post-title" value="Post Title" />

                        <input name="small_desc" value="{{ $post->small_desc ?? '' }}" type="text" id="small_desc"
                            class="form-control mb-2" placeholder="Post small desc" />

                        <!-- Editable Content -->
                        <textarea id="postContent" name="desc" class="form-control mb-2 post-content">
                            {!! $post->desc !!}
                        </textarea>

                        <!-- Image Upload Input for Editing -->
                        <input name="images[]" type="file" id="postImages" class="form-control mb-2" accept="image/*"
                            multiple />
                        <input type="hidden" name="skip_images_validation" value="true">
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <!-- Editable Category Dropdown -->
                        <select name="category_id" class="form-control mb-2 post-category">
                            <option disabled value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option @selected($post->category_id == $category->id) value="{{ $category->id }}">
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>

                        <!-- Editable Enable Comments Checkbox -->
                        <div class="form-check mb-2">
                            <input name="comment_able" class="form-check-input enable-comments" type="checkbox"
                                @checked($post->comment_able) />
                            <label class="form-check-label">
                                Enable Comments
                            </label>
                        </div>

                        <!-- Post Meta: Views and Comments -->
                        <div class="post-meta d-flex justify-content-between">
                            <span class="views">
                                <i class="fas fa-eye"></i> {{ $post->num_of_views }}
                            </span>
                            <span class="post-comments">
                                <i class="fas fa-comment"></i> {{ $post->comments->count() }}
                            </span>
                        </div>

                        <!-- Post Actions -->
                        <div class="post-actions mt-2">
                            {{--
                                <form action="{{ route('frontend.dashboard.post.delete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger delete-post-btn" name="slug" type="submit"
                                        value="{{ $post->slug }}">Delete</button>
                                </form> --}}

                            <button type="submit" class="btn btn-success save-post-btn ">
                                Save
                            </button>
                            <a href="{{ route('frontend.dashboard.profile') }}" class="btn btn-secondary cancel-edit-btn">
                                Cancel
                            </a>

                        </div>

                        </li>
                        <!-- Additional posts will be added dynamically -->
                    </ul>
                </section>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // initialize with defaults
            $("#postImages").fileinput({
                theme: 'fa5',
                allowedFileTypes: ['image'],
                maxFileCount: 5,
                showUpload: false,
                enableResumableUpload: false,
                initialPreviewAsData: true,
                initialPreview: [
                    @if ($post->images->count() > 0)
                        @foreach ($post->images as $image)
                            "{{ asset($image->path) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewConfig: [
                    @if ($post->images->count() > 0)
                        @foreach ($post->images as $image)
                            {
                                caption: "{{ $image->path }}",
                                width: '120px',
                                url: "{{ route('frontend.dashboard.post.image.delete', [$image->id, '_token' => csrf_token()]) }}",
                                key: "{{ $image->id }}",

                            },
                        @endforeach
                    @endif
                ],

            });

            $("#postContent").summernote({
                height: 300,

            });
        });
    </script>
@endpush
