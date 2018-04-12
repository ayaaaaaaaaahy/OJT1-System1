<html>

<head>
    @yield('title')
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="{{ asset('auth/img/useplogo.png') }}" type="image/x-icon" />

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('auth/css/bootstrap.min.css') }}">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('auth/css/lr.css') }}" id="theme-stylesheet">
    <!-- Font Awesome CDN-->
    <!-- you can replace it by local Font Awesome
    <script src="https://use.fontawesome.com/99347ac47f.js"></script>
    <!-- Font Icons CSS
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

</head>

<body>
    <div class="page login-page">
      <div class="d-flex align-items-center">
        <div class="form-holder">
          <div class="row">
            <div class="col-lg-8">
              <div class="cont">
              <div class="info d-flex flex-column align-items-center">
                <div class="content align-self-start w-100">
                  <div class="mx-auto" style="width: fit-content">
                    <div class="text-center logo" style="display: inline-block; vertical-align: middle;"><img alt="USeP Logo" class="mr-2" height="85" src="{{ asset('auth/img/useplogo.png') }}" width="85"></div>
                    <div class="htext" style="display: inline-block; vertical-align: middle;s">
                      <h2 class="m-0 text-left htext1">U<span class="htext1sub">niversity of</span> S<span class="htext1sub">outheastern</span> P<span class="htext1sub">hilippines</span></h2>
                      <hr class="my-1 htexthr">
                      <h3 class="m-0 text-left htext2">O<span class="htext2sub">ffice of the</span> S<span class="htext2sub">ecretary of the</span> U<span class="htext2sub">niversity</span></h3>
                    </div>
                  </div>
                </div>
                <div class="my-auto"></div>
                <div class="content align-self-end w-100">
                  <div class="row text-center">
                    <div class="col-xl-4 col-sm-12 col-12 mx-auto col-md-4 col-lg-4">
                      <p class="m-0"><i aria-hidden="true" class="fa fa-envelope-o"></i> osu@usep.edu.ph</p>
                    </div>
                    <div class="col-xl-4 col-sm-12 col-12 mx-auto col-md-4 col-lg-4">
                      <p class="pi-draggable m-0" draggable="true"><a class="alink" href="http://www.usep.edu.ph" style="color:white;"><i aria-hidden="true" class="fa fa-globe"></i> www.usep.edu.ph</a></p>
                    </div>
                    <div class="col-xl-4 col-sm-12 col-12 mx-auto col-md-4 col-lg-4">
                      <p class="pi-draggable m-0" draggable="true"><i aria-hidden="true" class="fa fa-phone"></i> (082) 227-8192 local 209 or 211</p>
                    </div>
                  </div>
                </div>
              </div>
              </div>
            </div>
            @yield('content') 
           </div>
        </div>
      </div>
    </div>

    <script src="{{ asset('auth/js/jquery.js') }}"></script>
    <script src="{{ asset('auth/js/parsley.js') }}"></script>
    <script src="{{ asset('auth/js/tether.min.js') }}"></script>
    <script src="{{ asset('auth/js/bootstrap.js') }}"></script>
    @yield('script')
</body>
</html>