@extends('layouts.dashboard.app')
@section('title')
    Users
@endsection
@section('body')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Roles Managment</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Roles Managment</h6>
            </div>
            <br>
            <div class="col-3">
                <a href="{{ route('dashboard.authorizations.create') }}" class="btn btn-info">Create New Role </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Permessions</th>
                                <th>Related Admins</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Permessions</th>
                                <th>Related Admins</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($authorizations as $authorization)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $authorization->role }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Permessions
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="dropdownMenuButton">
                                                @foreach ($authorization->permessions as $permession)
                                                    <a class="dropdown-item" href="#">{{ $permession }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $authorization->admins->count() }}</td>
                                    <td>{{ $authorization->created_at->format('Y-m-d h:m a') }}</td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            onclick="if(confirm('Do you want to delete this Role')){document.getElementById('delete_role_{{ $authorization->id }}').submit()} return false"><i
                                                class="fa fa-trash"></i></a>
                                        <a href="{{ route('dashboard.authorizations.edit', $authorization->id) }}"><i
                                                class="fa fa-edit"></i></a>
                                    </td>
                                </tr>

                                <form id="delete_role_{{ $authorization->id }}"
                                    action="{{ route('dashboard.authorizations.destroy', $authorization->id) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="5"> No authorizations</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $authorizations->appends(request()->input())->links() }}
                </div>

            </div>
        </div>

    </div>

    <style>
        .dropdown-menu {
            top: auto !important;
            bottom: auto !important;
            transform: translateY(0) !important;
        }
    </style>

    <!-- /.container-fluid -->
@endsection