
@extends('layouts.app') 

@section('title')
  <title>OSU | RESET PASSWORD</title>
@endsection

@section('style')
  <link rel="stylesheet"  href="{{ asset('auth/css/osulogin.css') }}" type="text/css">
@endsection 

@section('content')
  <div class="col-lg-5 col-md-6 col-sm-7 col-12 mx-auto p-3 formcont">
    <h4 class="text-center mb-4 mt-3 formhtext">RESET PASSWORD</h4>
    @if (session('status'))
    <div class="alert alert-success mx-auto p-2 formalert">

        {{ session('status') }}
    </div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger mx-auto p-2 formalert" role="alert">
        @foreach ($errors->all() as $error)
          <p class="m-0">{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <hr class="my-1 formhr">
    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}"  data-parsley-validate="">
            {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group forminputcont">
            <p class="formlabel">Enter Email:</p>
            <input id="email" autocomplete="off" class="form-control forminput" data-parsley-trigger="focus" data-parsley-type="email" name="email" value="{{ old('email') }}" required="" type="email">
        </div>
        <div class="form-group forminputcont">
            <p class="formlabel">Enter Password:</p>
            <input id="password" autocomplete="off" class="form-control forminput" name="password"  required="" type="password" id="password" data-parsley-trigger="focus">
        </div>
        <div class="form-group forminputcont">
            <p class="formlabel">Confirm Password:</p>
            <input autocomplete="off" class="form-control forminput" name="password_confirmation" 
                data-parsley-equalto="#password" data-parsley-trigger="focus" data-parsley-error-message="Please confirm your password" required="" type="password">
        </div>

        <div class="btn-group w-100" role="group">
            <button class="btn btn-danger w-100" type="submit">SUBMIT</button> 
        </div>
    </form>
  </div>
@endsection

