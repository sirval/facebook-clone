@extends('layouts.app')

@section('css')
     <!-- Links of CSS files -->
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
                    <div class="d-table">
                        <div class="d-table-cell">
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
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="register-form">
                    <h2>Register</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label>Full name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control @error('role') is-invalid @enderror" name="role" value="{{ old('role') }}" required>
                                <option value="">-- Select Role --</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                              </select>
                           
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            
                        </div>

                        
                        <button type="submit" class="default-btn">Register</button>
                        {{-- <div class="or-text"><span>Or</span></div>
                        <button type="submit" class="google-btn">Log In with Google</button> --}}
                    </form>
                    <div class="mt-2 align-item-right">
                        <label>Already a registered user?</label>
                        <a href="{{ route('login') }}" class="lost-your-password">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="home-btn-icon">
        <a href="{{ route('welcome') }}"><i class="flaticon-home"></i></a>
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





