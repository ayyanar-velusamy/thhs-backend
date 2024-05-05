@extends('layouts.auth')

@section('content')
<section class="register-page-wrapper position-relative">
    <div class="container">

        @if(session()->has('success'))
            
            <div class="alert alert-success" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif
        
        @if(session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('error') }}
        </div>
        @endif
        <div class="register-page-parent">
            <div class="position-relative">
                <div id="carouselExampleControls" class="carousel slide position-unset" data-bs-ride="carousel">
                    
                    <div class="carousel-inner img-wrapper">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/login_1.svg') }}" class="d-block w-100" alt="images" />
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="form-wrapper">
                <img src="{{ asset('images/logo.svg') }}" class="logo-img" />
                <div class="title-wrapper">
                    <h1>{{ __('Reset Password') }}</h1>
                    <div class="small-bar"></div>
                </div>
               
                <form class="form-field-wrapper" method="POST" action="{{ route('password.update') }}" id="reset-form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                    <input id="password" type="password" class="@error('password') is-invalid @enderror" placeholder="New Password" name="password" required autocomplete="new-password">
                    <input id="password-confirm" type="password"  name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                    
                    <div class="btn-wrap">
                        <button class="login-btn-wrap" id="reset-submit" type="submit" > {{ __('Reset Password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

