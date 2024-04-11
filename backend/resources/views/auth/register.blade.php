@extends('layouts.auth')
@section('content')
<section class="register-page-wrapper">
  <div class="container">
    <div class="register-page-parent">
      <div class="position-relative">
        <div id="" class="carousel slide">
          <div class="carousel-inner img-wrapper">
            <div class="carousel-item active">
              <img src="{{ asset('images/register_sidebar.svg') }}" class="d-block w-100" alt="images" />
            </div>
            <div class="carousel-item img-wrapper">
              <img src="{{ asset('images/register_sidebar.svg') }}" class="d-block w-100" alt="images" />
            </div>
            <div class="carousel-item img-wrapper">
              <img src="{{ asset('images/register_sidebar.svg') }}" class="d-block w-100" alt="images" />
            </div>
          </div>
          <button class="carousel-control-prev d-none" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev"></button>
          <button class="carousel-control-next d-none" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next"></button>
        </div>
      </div>
      <div class="form-wrapper">
        <img src="{{ asset('images/logo.svg') }}" class="logo-img" />
        <div class="title-wrapper">
          <div class="small-bar"></div>
          <h1>Prospect <span>Registration</span></h1>
        </div>

        <form method="POST" action="{{ route('register') }}" class="form-field-wrapper" id="register_form">
          @csrf
          <div class="checkbox-tick-wrapper d-flex align-items-center @error('authorize_to_us') is-invalid @enderror">
            <label class="d-flex align-items-center">
              <input type="checkbox" name="authorize_to_us" id="authorize_to_us" required  />
              <span class="cr"><i class="icon icon-tick-white"></i></span>
              <p>
                Authorized to work in the U.S. on an unrestricted basis?
              </p>
            
            </label>
          
          </div>
          @error('authorize_to_us')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
          <input type="text" name="firstname" placeholder="First Name" value="{{ old('firstname') }}" class="@error('password') is-invalid @enderror" required autofocus />
          @error('firstname')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
          <input type="text" name="lastname" placeholder="Last Name" value="{{ old('lastname') }}" class="@error('password') is-invalid @enderror" required />
          @error('lastname')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
          <div class="select-wrapper position-relative">
            <select class="select-control" name="position" required>

              <option value="">Position</option>
              <option value="1">CNA – Certified Nursing Assistant</option>
              <option value="2">DON – Director of Nursing</option>
              <option value="3">HHA – Home Health Aide</option>
              <option value="4">Human Resource</option>
              <option value="5">LPN – Practical Registered Nurse</option>
              <option value="6">MSW – Medical Social Worker</option>
              <option value="7">OT – Occupational Therapist</option>
              <option value="8">OTA - Occupational Therapist Assistant</option>
              <option value="9">PT- Physical Therapist</option>
              <option value="10">PTA – Physical Therapist Assistant</option>
              <option value="11">RN- Registered Nurse</option>
            </select>
          </div>
          <input type="text" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" class="@error('email') is-invalid @enderror" />
          @error('email')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
          <div class="password-wrapper position-relative">
            <input type="password" name="password" placeholder="Password" class="@error('password') is-invalid @enderror" required /><i class="icon icon-eye"></i>
            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
            <!-- <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"> -->
          </div>
          <div class="password-wrapper position-relative">
            <input id="password_confirmation" type="password" placeholder="Confirm Password" name="password_confirmation" required><i class="icon icon-eye"></i>
          </div>

          <div class="btn-wrap">
            <button class="login-btn-wrap" id="register_submit" type="submit">Register</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection