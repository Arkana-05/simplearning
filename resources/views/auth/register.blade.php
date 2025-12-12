@extends('layouts.loginregis')
@section('title')
    <title>Register | Sistem Informasi E-learning</title>
@endsection
@section('video')
    <video autoplay muted loop id="background-video">
        <source src="{{ asset('img/vid.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
@endsection
@section('content')
<div class="wrapper">
    <div class="title-text">
        <div class="title signup">Signup Form</div>
      <div class="title login">Login Form</div>
    </div>
    <div class="form-container">
      <div class="slide-controls">
        <input type="radio" name="slide" id="login" >
        <input type="radio" name="slide" id="signup" checked>
        <label for="login" class="slide login"><a href="{{ route('login') }}" class="text-decoration-none" style="text-decoration: none">Login</a></label>
          <label for="signup" class="slide signup" >Signup</label>
        <div class="slider-tab"></div>
      </div>
      <div class="form-inner">
        <form method="POST" action="{{ route('register') }}" class="signup">
          @csrf
          <div class="field">
            <input type="text" placeholder="Name" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" >
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field">
            <input type="text" placeholder="Email Address" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field">
            <input type="password" placeholder="Password"  id="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field">
            <input placeholder="Confirm password" for="password-confirm" id="password-confirm" type="password" name="password_confirmation" required>
          </div>
          <div class="field btn">
            <div class="btn-layer"></div>
            <input type="submit" value="Signup">
          </div>
        </form>
      </div>
    </div>
</div>


@if(Session::has('error'))
<script>
    swal({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
    })
</script>
@endif
@endsection
