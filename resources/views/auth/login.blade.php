@extends('layouts.frontend.app')
@section('title')
    Login
@endsection
@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" id="loginButton">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="overlay" id="captchaOverlay" style="display: none;">
                                <div class="captcha-container">
                                    {!! NoCaptcha::display() !!}
                                </div>
                            </div>

                            <style>
                                /* الغلاف الكامل */
                                .overlay {
                                    position: fixed;
                                    top: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 100%;
                                    background: rgba(0, 0, 0, 0.7);
                                    /* خلفية نصف شفافة */
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    z-index: 9999;
                                    /* ضمان الظهور فوق جميع العناصر */
                                }

                                /* صندوق الكابتشا */
                                .captcha-container {
                                    background: #fff;
                                    padding: 20px;
                                    border-radius: 8px;
                                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
                                    /* إضافة تأثير الظل */
                                    text-align: center;
                                    max-width: 400px;
                                    /* عرض مناسب */
                                    width: 90%;
                                    /* قابل للتكيف مع الشاشات الصغيرة */
                                }
                            </style>
                            <div class="row">
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <br>
                            <div class="d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-4" style="margin: auto">
                                        <a class="btn btn-info" href="{{ route('auth.socilate.redirect', 'google') }}">
                                            <i class="fab fa-google"></i></a>
                                    </div>
                                    <div class="col-4">
                                        <a class="btn btn-info" href="{{ route('auth.socilate.redirect', 'facebook') }}">
                                            <i class="fab fa-facebook"></i></a>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {!! NoCaptcha::renderJs() !!}
    <script>
        document.getElementById('loginButton').addEventListener('click', function(event) {
            event.preventDefault(); // منع إعادة تحميل الصفحة

            // عرض نافذة الكابتشا
            document.getElementById('captchaOverlay').style.display = 'flex';

            // تحقق من الكابتشا بعد تفاعل المستخدم
            setTimeout(() => {
                const captchaResponse = grecaptcha.getResponse(); // الحصول على الاستجابة

                if (captchaResponse.length === 0) {
                    document.getElementById('captchaOverlay').style.display = 'none';
                } else {
                    // إرسال النموذج إذا تم التحقق
                    document.getElementById('loginForm').submit();
                }
            }, 5000); // تأخير بسيط للسماح للمستخدم بالتفاعل
        });
    </script>
@endpush
