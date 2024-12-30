@extends('layouts.dashboard.app')
@section('title')
    Setting
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
@endpush
@section('body')
    <div class="d-flex justify-content-center">
        <form action="{{ route('dashboard.settings.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body shadow mb-4" style="min-width: 100ch">
                <h2>Update Setting</h2><br><br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable">Site Name</label>
                            <input type="text" value="{{ $get_setting->site_name }}" name="site_name"
                                placeholder="Enter User site_name" class="form-control">
                            @error('site_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Email</label>
                            <input type="text" value="{{ $get_setting->email }}" name="email"
                                placeholder="Enter User email" class="form-control">
                            @error('email')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable">Phone</label>
                            <input type="text" value="{{ $get_setting->phone }}" name="phone"
                                placeholder="Enter User phone" class="form-control">
                            @error('phone')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Country</label>

                            <input type="text" value="{{ $get_setting->country }}" name="country"
                                placeholder="Enter User country" class="form-control">
                            @error('country')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> City</label>
                            <input type="text" value="{{ $get_setting->city }}" name="city"
                                placeholder="Enter city Name" class="form-control">
                            @error('city')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Street</label>
                            <input type="text" value="{{ $get_setting->street }}" name="street"
                                placeholder="Enter street Name" class="form-control">
                            @error('street')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Facebook</label>
                            <input type="text" value="{{ $get_setting->facebook }}" name="facebook"
                                placeholder="Enter facebook Link " class="form-control">
                            @error('facebook')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Twitter</label>
                            <input type="text" value="{{ $get_setting->twitter }}" name="twitter"
                                placeholder="Enter twitter link " class="form-control">
                            @error('twitter')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Instagram</label>
                            <input type="text" value="{{ $get_setting->instagram }}" name="instagram"
                                placeholder="Enter insagram Link" class="form-control">
                            @error('instagram')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Youtube</label>
                            <input type="text" value="{{ $get_setting->youtube }}" name="youtube"
                                placeholder="Enter Youtupe Link " class="form-control">
                            @error('youtube')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="lable"> Small Description</label>
                            <textarea type="text" name="small_desc" placeholder="Enter small_desc " class="form-control">{{ $get_setting->small_desc }}</textarea>
                            @error('small_desc')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            Logo : <input type="file" class="dropify" name="logo" class="form-control">
                            @error('logo')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                            <br>
                            <img class="img-thumbnail" src="{{ asset($get_setting->logo) }}">

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            Favicon : <input type="file" class="dropify" name="favicon" class="form-control">
                            @error('favicon')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                            <br>
                            <img class="img-thumbnail" src="{{ asset($get_setting->favicon) }}">

                        </div>
                    </div>
                </div>
                <br>
                <input name="setting_id" value="{{ $get_setting->id }}" hidden>
                <button type="submit" class="btn btn-primary"> Update Setting</button>
            </div>

        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify({
            messages: {
                'default': 'Drop a file here',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });
    </script>
@endpush
