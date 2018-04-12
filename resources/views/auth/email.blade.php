@extends('layouts.app') 

@section('title')
  <title>OSU | FORGOT PASSWORD</title>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('auth/css/osulogin.css') }}" type="text/css">
@endsection 

@section('content')
  <div class="col-lg-5 col-md-6 col-sm-7 col-12 mx-auto p-3 formcont">
    <h4 class="text-center mb-4 mt-3 formhtext">FORGOT PASSWORD</h4>
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
    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}"  data-parsley-validate="">
            {{ csrf_field() }}
        <div class="form-group forminputcont">
            <input autocomplete="off" class="form-control forminput" data-parsley-trigger="focus" data-parsley-type="email" name="email" placeholder="Enter email" required="" type="email" value="{{ old('email') }}">
        </div>

        <div class="btn-group w-100" role="group">
            <a class="btn btn-outline-danger w-50 formoptbtn" href="{{ route('login')}}" role="button">BACK</a>
            <button class="btn btn-danger w-50" type="submit">SUBMIT</button> 
        </div>
    </form>
  </div>
@endsection