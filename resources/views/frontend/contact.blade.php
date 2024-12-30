@extends('layouts.frontend.app')
@section('title')
    Contact Us
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a>Contact Us</a>
    </li>
@endsection
@section('body')
    <!-- Contact Start -->
    <div class="contact">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="contact-form">
                        <form action="{{ route('frontend.contact.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <input name="name" type="text" class="form-control" placeholder="Your Name" />
                                    <strong class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </strong>
                                </div>
                                <div class="form-group col-md-4">
                                    <input name="email" type="email" class="form-control" placeholder="Your Email" />
                                    <strong class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </strong>
                                </div>
                                <div class="form-group col-md-4">
                                    <input name="phone" type="text" class="form-control" placeholder="Your phone" />
                                </div>
                                <strong class="text-danger">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </strong>
                            </div>
                            <div class="form-group">
                                <input name="title" type="text" class="form-control" placeholder="Subject" />
                                <strong class="text-danger">
                                    @error('title')
                                        {{ $message }}
                                    @enderror
                                </strong>
                            </div>
                            <div class="form-group">
                                <textarea name="body" class="form-control" rows="5" placeholder="Message"></textarea>
                                <strong class="text-danger">
                                    @error('body')
                                        {{ $message }}
                                    @enderror
                                </strong>
                            </div>
                            <div>
                                <button class="btn" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <h3>Get in Touch</h3>
                        <p class="mb-4">
                            The contact form is currently inactive. Get a functional and
                            working contact form with Ajax & PHP in a few minutes. Just copy
                            and paste the files, add a little code and you're done.
                        </p>
                        <h4><i class="fa fa-map-marker"></i>{{ $get_setting->street }}, {{ $get_setting->city }},
                            {{ $get_setting->country }} </h4>
                        <h4><i class="fa fa-envelope"></i>{{ $get_setting->email }}</h4>
                        <h4><i class="fa fa-phone"></i>{{ $get_setting->phone }}</h4>
                        <div class="social">
                            <a href="{{ $get_setting->twitter }}" title="twitter"><i class="fab fa-twitter"></i></a>
                            <a href="{{ $get_setting->facebook }}" title="facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $get_setting->instagram }}" title="instagram"><i class="fab fa-instagram"></i></a>
                            <a href="{{ $get_setting->youtube }}" title="youtube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
