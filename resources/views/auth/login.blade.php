@extends('layouts.loginregis')

@section('title')
    <title>Login | Sistem Informasi E-learning</title>
    
@endsection
@section('video')
    <video autoplay muted loop id="background-video">
        <source src="https://simplearning-j968.vercel.app/public/img/vid.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
@endsection
@section('content')
<div class="wrapper">
    <div class="title-text">
      <div class="title login">Login Form</div>
      <div class="title signup">Signup Form</div>
    </div>
    <div class="form-container mb-2">
      {{--  <div class="slide-controls" style="width: 50%; margin: 0 auto; display: flex; justify-content: center; position: relative;">
        <label for="login" class="slide login">Login</label>
        <div class="slider-tab" style="width: 100%;"></div>
      </div>  --}}
      <div class="form-inner">
        <form method="POST" action="{{ route('login') }}" class="login">
          @csrf
          <div class="field">
            <input type="text" placeholder="Email Address" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field">
            <input type="password" placeholder="Password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          
          <div class="field btn">
            <div class="btn-layer"></div>
            <input type="submit" value="Login">
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
