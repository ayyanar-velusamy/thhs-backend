@extends('layouts.auth')
@section('content')
    <section class="register-page-wrapper login">
        @if(session()->has('error'))
        <div id="myToast" class="toast failure align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
              <div class="toast-body">
                {{ session()->get('error') }}
              </div>
              <button onclick="hideToast()" type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
    @endif
    @if(session()->has('message'))
        <div id="myToast" class="toast success align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
              <div class="toast-body">
                {{ session()->get('message') }}
              </div>
              <button onclick="hideToast()" type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
    @endif
        <div class="container">
            <div class="register-page-parent">
                <div class="position-relative">
                    <div id="carouselExampleControls" class="carousel slide position-unset" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner img-wrapper">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/login_1.svg') }}" class="d-block w-100" alt="images" />
                            </div>
                            <div class="carousel-item img-wrapper">
                                <img src="{{ asset('images/login_2.svg') }}" class="d-block w-100" alt="images" />
                            </div>
                            <div class="carousel-item img-wrapper">
                                <img src="{{ asset('images/login_3.svg') }}" class="d-block w-100" alt="images" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-wrapper">
                    <img src="{{ asset('images/logo.svg') }}" class="logo-img" />
                    <div class="title-wrapper">
                        <h1>Login</h1>
                        <div class="small-bar"></div>
                    </div>
                   
                    <form class="form-field-wrapper" method="POST" action="{{ route('login') }}" id="signin-form">
                        @csrf
                        <input type="text" name="email" placeholder="Username" value="{{ old('email') }}" required
                            autocomplete="email" autofocus />

                        <div class="password-wrapper position-relative">
                            <input type="password" name="password" placeholder="Password" required /><i
                                class="icon icon-eye"></i>
                        </div>
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        @error('g-recaptcha-response')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="forgot-password-wrapper d-flex align-items-center justify-content-between">
                            <div class="checkbox-tick-wrapper d-flex align-items-center">
                                <label class="d-flex align-items-center">
                                    <input type="checkbox" value="" />
                                    <span class="cr"><i class="icon icon-tick-white"></i></span>
                                    <p>Remember</p>
                                </label>
                            </div>
                            <a href="#">Forgot password?</a>
                        </div>
                        <div class="btn-wrap">
                            <button class="login-btn-wrap" type="submit" id="signin_submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
