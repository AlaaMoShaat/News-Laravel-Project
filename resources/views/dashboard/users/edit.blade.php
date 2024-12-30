@extends('layouts.dashboard.app')
@section('title')
    Edit User
@endsection

@section('body')
    <center>
        <form action="{{ route('dashboard.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body shadow mb-4 col-10">
                <h2>Edit User</h2><br><br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                placeholder="Enter User name" class="form-control">
                            @error('name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                placeholder="Enter User Username" class="form-control">
                            @error('username')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                placeholder="Enter User Email" class="form-control">
                            @error('email')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                placeholder="Enter User Phone" class="form-control">
                            @error('phone')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <select required name="status" class="form-control">
                                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <select required name="email_verified_at" class="form-control">
                                <option value="1" {{ $user->email_verified_at != null ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ $user->email_verified_at == null ? 'selected' : '' }}>Not Active
                                </option>
                            </select>
                            @error('email_verified_at')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="country" value="{{ old('country', $user->country) }}"
                                placeholder="Enter Country Name" class="form-control">
                            @error('country')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="city" value="{{ old('city', $user->city) }}"
                                placeholder="Enter City Name" class="form-control">
                            @error('city')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="street" value="{{ old('street', $user->street) }}"
                                placeholder="Enter Street name" class="form-control">
                            @error('street')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="file" name="image" class="form-control">
                            @error('image')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Enter Password" class="form-control">
                            @error('password')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="password" name="password_confirmation" placeholder="Enter Password again"
                                class="form-control">
                        </div>
                    </div>
                </div><br>
                <button type="submit" class="btn btn-primary" style="float: right">Update User</button>
            </div>

        </form>

    </center>
@endsection
