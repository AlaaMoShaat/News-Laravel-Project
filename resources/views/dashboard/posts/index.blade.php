@extends('layouts.dashboard.app')
@section('title')
    posts
@endsection
@section('body')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Posts</h1>
        <p class="mb-4">DataTables is a third party .</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"> Posts Managment</h6>
            </div>

            @include('dashboard.posts.filter.filter')

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>title</th>
                                <th>Category</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->category->name }}</td>
                                    <td>{{ $post->user->name ?? $post->admin->name }}</td>
                                    <td>
                                        <p style="align-items: center; border-radius: 5px; text-align: center"
                                            class="@if ($post->status) btn-info  @else btn-danger @endif">
                                            {{ $post->status == 1 ? 'active' : 'inactive' }}</p>
                                    </td>
                                    <td>{{ $post->num_of_views }}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-danger"
                                            onclick="if(confirm('Do you want to delete the post')){document.getElementById('delete_post_{{ $post->id }}').submit()} return false"><i
                                                class="fa fa-trash"></i></a>
                                        <a href="{{ route('dashboard.posts.changeStatus', $post->id) }}"
                                            class="btn @if ($post->status == 1) btn-danger @else btn-info @endif"><i
                                                class="fa @if ($post->status == 1) fa-stop @else fa-play @endif"></i></a>
                                        <a class="btn btn-info"
                                            href="{{ route('dashboard.posts.show', ['post' => $post->id, 'page' => request()->page]) }}"><i
                                                class="fa fa-eye"></i></a>
                                        @if ($post->admin_id)
                                            <a class="btn btn-info" href="{{ route('dashboard.posts.edit', $post->id) }}"><i
                                                    class="fa fa-edit"></i></a>
                                        @endif
                                    </td>
                                </tr>

                                <form id="delete_post_{{ $post->id }}"
                                    action="{{ route('dashboard.posts.destroy', $post->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @empty
                                <tr>
                                    <tdv class="alert alert-info" colspan="6"> No posts</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $posts->appends(request()->input())->links() }}
                </div>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection