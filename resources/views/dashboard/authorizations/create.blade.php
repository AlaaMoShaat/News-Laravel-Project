@extends('layouts.dashboard.app')
@section('title')
    Create Role
@endsection

@section('body')
    <div class="d-flex justify-content-center">
        <form action="{{ route('dashboard.authorizations.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body shadow mb-4" style="max-width: 90ch">
                <div class="row">
                    <div class="col-9">
                        <h2>Add New Role</h2>
                    </div>
                    <div class="col-3">
                        <a href="{{ route('dashboard.authorizations.index') }}" class="btn btn-primary">Back To Roles</a>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" name="role" placeholder="Enter Role Name" class="form-control">
                            @error('name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="checkbox" id="select-all"> Select All
                        </div>
                    </div>

                    @foreach (config('authorization.permessions') as $key => $value)
                        <div class="col-4">
                            <div class="form-group">
                                {{ $value }} : <input value="{{ $key }}" type="checkbox"
                                    class="permession-checkbox" name="permessions[]">
                            </div>
                        </div>
                    @endforeach
                </div>

                <script>
                    document.getElementById('select-all').addEventListener('change', function() {
                        const checkboxes = document.querySelectorAll('.permession-checkbox');
                        checkboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                    });
                </script>

                <button type="submit" class="btn btn-primary">Create New Role</button>
            </div>
            @error('permessions')
                <span class="alert alert-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </form>
    </div>
@endsection
