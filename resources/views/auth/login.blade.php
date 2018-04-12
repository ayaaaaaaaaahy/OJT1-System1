@extends('layouts.auth') 

@section('title')
  <title>OSU | Home</title>
@endsection

@section('content')
  <!-- Form Panel    -->
  <div class="col-lg-4 bg-white">
    <div class="form d-flex align-items-center">
      <div class="content">
        <form action="{{ route('login') }}" data-parsley-validate="" method="post">
          {{ csrf_field() }}
          <h1 class="mb-3 text-center">LOGIN</h1>
            @if ($errors->any())
              <div class="alert alert-danger mx-auto p-2 formalert" role="alert">
                @foreach ($errors->all() as $error)
                  <p class="m-0">{{ $error }}</p>
                @endforeach
              </div>
            @endif
            
              @if(session()->has('status'))
                @if (session('status'))
                  <div class="alert alert-warning mx-auto p-2 formalert" role="alert">
                    {{ session('status') }}
                    {{ session()->forget('status') }}
                  </div>
                @endif
              @endif

              @if(session()->has('success_register'))
                @if (session('success_register'))
                  <div class="alert alert-success mx-auto p-2 formalert" role="alert">
                    {{ session('success_register') }}
                    {{ session()->forget('success_register') }}
                  </div>
                @endif
              @endif

          <hr class="mb-4 formhr">
          <div class="form-group">
            <label class="form-control-label">Email:</label> <input class="form-control" data-parsley-trigger="focus" data-parsley-type="email" placeholder="Email Address" required="" name="email" type="email">
          </div>
          <div class="form-group">
            <label class="form-control-label">Password:</label> <input class="form-control" placeholder="Password" required=""  name="password" type="password">
          </div>
          <div class="form-group terms-conditions text-center">
            <input class="checkbox-template" id="license" type="checkbox"> <label for="license">Remember me</label>
          </div>
          <div class="form-group">
            <input class="btn btn-danger w-100" type="submit" value="Signin">
          </div>
        </form><a class="forgot-pass" href="#">Forgot Password?</a><br>
        <small>Do not have an account?</small> <a class="signup" href="{{ route('register')}}">Signup</a>
      </div>
    </div>
  </div>
@endsection