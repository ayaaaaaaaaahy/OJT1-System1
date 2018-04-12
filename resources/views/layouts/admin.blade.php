<html>

<head>
    @yield('title')
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="{{ asset('auth/img/useplogo.png') }}" type="image/x-icon" />

    <!-- Custombox CSS-->
    <link rel="stylesheet" href="{{ asset('auth/css/custombox.min.css') }}">
    <!-- SweetAlert CSS-->
    <link rel="stylesheet" href="{{ asset('auth/css/sweetalert.css') }}">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('auth/css/bootstrap.css') }}">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('auth/css/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('auth/css/custom.css') }}">
    <!-- Font Awesome CDN-->
    <!-- you can replace it by local Font Awesome-->
    <script src="https://use.fontawesome.com/99347ac47f.js"></script>
    <!-- Font Icons CSS-->
    <link rel="stylesheet" href="https://file.myfontastic.com/da58YPMQ7U5HY8Rb6UxkNf/icons.css">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

</head>

<body>
  <div class="page home-page">
  <!-- Main Navbar-->
    <header class="header">
      <nav class="navbar">
        <div class="container-fluid">
          <div class="navbar-holder d-flex align-items-center justify-content-between">
            <!-- Navbar Header-->
            <div class="navbar-header">
                <!-- Navbar Brand -->
                <a href="index.html" class="navbar-brand">
                  <div class="brand-text brand-big hidden-lg-down">
                    <span>OSU </span><strong> Dashboard</strong>
                  </div>
                  <div class="brand-text brand-small">
                    <strong>OSU</strong>
                  </div>
                </a>
                <!-- Toggle Button-->
              <a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
            </div>
            <!-- Navbar Menu -->
            <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
              <!-- Logout    -->
              <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link logout"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                   Logout<i class="fa fa-sign-out"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <div class="page-content d-flex align-items-stretch" style=" min-height: calc(100vh - 70px); max-height: fit-content;">
      <!-- Side Navbar -->
      <nav class="side-navbar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img alt="..." class="img-fluid rounded-circle" src="{{asset('auth/img/avatar-alec.png')}}"></div>
          <div class="title ml-2">
            <h1 class="h4 mb-1">{{ Auth::user()->u_fname }}&nbsp;{{ Auth::user()->u_lname }}</h1>
          </div>
        </div><!-- Sidebar Navidation Menus-->
        <span class="heading">Main</span>
        <ul class="list-unstyled">
          <li @yield('a1') >
            <a href="{{route('home')}}"><i class="icon-home"></i>Dashboard</a>
          </li>
          <li @yield('a2') >
            <a aria-expanded="false" data-toggle="collapse" href="#dashvariants1"><i class="icon-form"></i>Document</a>
              <ul class="collapse list-unstyled" id="dashvariants1">
                <li>
                  <a href="{{route('upload')}}">Upload</a>
                </li>
                <li>
                  <a href="{{route('editdelete')}}">Recycle Bin</a>
                </li>
              </ul>
          </li>
          <li @yield('a3')>
            <a aria-expanded="false" data-toggle="collapse" href="#dashvariants2"><i class="icon-user"></i>User</a>
              <ul class="collapse list-unstyled" id="dashvariants2">
                <li>
                  <a href="{{route('acceptuser')}}">Accept User</a>
                </li>
                <li>
                  <a href="{{route('disableuser')}}">Disable User</a>
                </li>
              </ul>
          </li>
          <li @yield('a4') >
            <a aria-expanded="false" data-toggle="collapse" href="#dashvariants3"><i class="icon-clock"></i>History</a>
              <ul class="collapse list-unstyled" id="dashvariants3">
                <li>
                  <a href="{{route('adocumenthistory')}}">Document</a>
                </li>
                <li>
                  <a href="{{route('auserhistory')}}">User</a>
                </li>
              </ul>
          </li>          
        </ul>
      </nav>
      @yield('content')
    </div>
  </div>

  @yield('modal')


    <script src="{{ asset('auth/js/jquery.js') }}"></script>
    <script src="{{ asset('auth/js/parsley.js') }}"></script>
    <script src="{{ asset('auth/js/tether.min.js') }}"></script>
    <script src="{{ asset('auth/js/bootstrap.js') }}"></script>
    <script src="{{ asset('auth/js/custombox.min.js') }}"></script>
    <script src="{{ asset('auth/js/sweetalert.min.js') }}"></script>
    <script >
    $('.list-unstyled>li>a').on('click', function(){
        $('.list-unstyled').collapse('hide');
    });

    $('#toggle-btn').on('click', function (e) {
        e.preventDefault();
        $(this).toggleClass('active');

        $('.side-navbar').toggleClass('shrinked');
        $('.content-inner').toggleClass('active');

        if ($(window).outerWidth() > 1183) {
            if ($('#toggle-btn').hasClass('active')) {
                $('.navbar-header .brand-small').hide();
                $('.navbar-header .brand-big').show();
            } else {
                $('.navbar-header .brand-small').show();
                $('.navbar-header .brand-big').hide();
            }
        }

        if ($(window).outerWidth() < 1183) {
            $('.navbar-header .brand-small').show();
        }
    });
    </script>
    @yield('script')
</body>
</html>