@extends('layouts.dashboard.app')
@section('title')
    categories
@endsection
@section('body')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">DataTables is a third party plugin that is </a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Categories Managment</h6>
            </div>

            @include('dashboard.categories.filter.filter')
            {{-- table data --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Posts Count</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <p style="align-items: center; border-radius: 5px; text-align: center"
                                            class="@if ($category->status) btn-info  @else btn-danger @endif">
                                            {{ $category->status == 1 ? 'active' : 'inactive' }}</p>
                                    </td>
                                    <td>{{ $category->posts_count }}</td>
                                    <td>{{ $category->created_at }}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-danger"
                                            onclick="if(confirm('Do you want to delete the category')){document.getElementById('delete_category_{{ $category->id }}').submit()} return false"><i
                                                class="fa fa-trash"></i></a>
                                        <a href="{{ route('dashboard.categories.changeStatus', $category->id) }}"
                                            class="btn @if ($category->status == 1) btn-danger @else btn-info @endif"><i
                                                class="fa @if ($category->status == 1) fa-stop @else fa-play @endif"></i></a>
                                        <a class="btn btn-info" href="javascript:void(0)"><i class="fa fa-edit"
                                                data-toggle="modal"
                                                data-target="#edit-category-{{ $category->id }}"></i></a>
                                    </td>
                                </tr>

                                <form id="delete_category_{{ $category->id }}"
                                    action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                {{-- edit Category modal --}}
                                @include('dashboard.categories.edit')
                                {{-- end edit category modal --}}
                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="6"> No categories</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $categories->appends(request()->input())->links() }}
                </div>

            </div>
        </div>

        {{-- modal add new category --}}
        @include('dashboard.categories.create')
    </div>
    <!-- /.container-fluid -->
@endsection
