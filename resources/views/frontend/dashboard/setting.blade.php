@extends('layouts.frontend.app')
@section('title')
    Setting
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a>Setting</a>
    </li>
@endsection
@section('body')
    <!-- Dashboard Start-->
    <div class="dashboard container">
        <!-- Sidebar -->
        @include('frontend.dashboard._sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Settings Section -->
            <section id="settings" class="content-section active">
                <h2>Settings</h2>
                <form action="{{ route('frontend.dashboard.setting.update') }}" method="POST" class="settings-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input name="name" type="text" id="name" value="{{ $user->name }}" />
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input name="username" type="text" id="username" value="{{ $user->username }}" />
                        @error('username')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input name="email" type="email" id="email" value="{{ $user->email }}" />
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="profile-image">Profile Image:</label>
                        <input name="image" type="file" id="profile-image" accept="image/*" />
                        <div class="form-group">
                            <img id="profile_image" class="img-thumbnail" src="{{ asset($user->image) }}" width="180px">
                        </div>
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="country">Country:</label>
                        <input name="country" type="text" id="country" value="{{ $user->country }}" />
                        @error('country')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input name="city" type="text" id="city" value="{{ $user->city }}" />
                        @error('city')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input name="street" type="text" id="street" value="{{ $user->street }}" />
                        @error('street')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input name="phone" type="text" id="street" value="{{ $user->phone }}" />
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="save-settings-btn">
                        Save Changes
                    </button>
                </form>

                <!-- Form to change the password -->
                <form action="{{ route('frontend.dashboard.setting.changePassword') }}" method="POST"
                    class="change-password-form">
                    @csrf
                    <h2>Change Password</h2>
                    <div class="form-group">
                        <label for="current-password">Current Password:</label>
                        <input name="current_password" type="password" id="current-password"
                            placeholder="Enter Current Password" class="@error('current_password') is-invalid @enderror"
                            required />
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password:</label>
                        <input name="password" type="password" id="new-password" placeholder="Enter New Password"
                            class="@error('password') is-invalid @enderror" required />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm New Password:</label>
                        <input name="password_confirmation" type="password" id="confirm-password"
                            placeholder="Enter Confirm New Password"
                            class="@error('password_confirmation') is-invalid @enderror" required />
                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary change-password-btn">
                        Change Password
                    </button>
                </form>

            </section>
        </div>
    </div>

    <!-- Dashboard End-->
@endsection

@push('js')
    <script>
        $(document).on('change', '#profile-image', function(e) {
            e.preventDefault();
            var file = this.files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#profile_image').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
