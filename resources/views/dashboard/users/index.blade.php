@extends('layouts.dashboard.app')
@section('title')
    Users
@endsection
@section('body')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><a style="text-decoration: none"
                href="{{ route('dashboard.users.index') }}">Users</a></h1>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><a style="text-decoration: none"
                        href="{{ route('dashboard.users.index') }}">Users</a></h6>
            </div>
            @include('dashboard.users.filter.filter')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <p style="align-items: center; border-radius: 5px; text-align: center"
                                            class="@if ($user->status) btn-info  @else btn-danger @endif">
                                            {{ $user->status == 1 ? 'active' : 'inactive' }}</p>
                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <button class="btn btn-danger"
                                            onclick="if(confirm('Do you want delete the user?')){document.getElementById('delete_user_{{ $user->id }}').submit()} return false"><i
                                                class="fa fa-trash"></i></button>
                                        <a href="{{ route('dashboard.users.changeStatus', $user->id) }}"
                                            title="@if ($user->status == 1) block @else unblock @endif"
                                            class="btn @if ($user->status == 1) btn-danger @else btn-info @endif">
                                            <i
                                                class="fa @if ($user->status == 1) fa-stop @else fa-play @endif"></i>
                                        </a>
                                        <a class="btn btn-info" href="{{ route('dashboard.users.edit', $user->id) }}"><i
                                                class="fa fa-edit"></i></a>
                                        <a class="btn btn-info" href="{{ route('dashboard.users.show', $user->id) }}"><i
                                                class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                <form id="delete_user_{{ $user->id }}"
                                    action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                </form>
                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="6">No Users</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{ $users->appends(request()->input())->links() }}
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
