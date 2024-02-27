@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/metismenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
@endsection

@section('content')
<div class="profile-authentication-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="profile-authentication-image">
                    <div class="content-image">
                        <div class="logo">
                            <a href="{{ route('welcome') }}"><h4 class="text-white">WOW By Alex</h4></a>
                        </div>
                        <div class="vector-image">
                            <img src="{{ asset('assets/images/gallery/wow.gif') }}" alt="image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="login-form">
                    <h2>Login</h2>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label>Username or email</label>
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="remember-me-wrap d-flex justify-content-between align-items-center">
                            <p>
                                <input type="checkbox" id="test1" name="remember">
                                <label for="test1">Remember me</label>
                            </p>

                            <div class="lost-your-password-wrap">
                                <a href="{{ route('password.update') }}" class="lost-your-password">Forgot password ?</a>
                            </div>
                        </div>
                        <button type="submit" class="default-btn mb-4">Login</button>
                        {{-- <div class="or-text"><span>Or</span></div>
                        <button type="submit" class="google-btn">Log In with Google</button> --}}
                    </form>
                    <div class="mt-2 align-item-right mb-4">
                        <label>Do you want to join the world of interconnected users?</label>
                        <a href="{{ route('register') }}" class="lost-your-password mb-4">Register Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="home-btn-icon">
        <a href="{{ route('home') }}"><i class="flaticon-home"></i></a>
    </div>
</div>

@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
@endsection

