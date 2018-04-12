@extends('layouts.auth')

@section('title')
<title> OSU | Register </title>
@endsection

@section('content')
            
            <!-- Form Panel    -->
            <div class="col-lg-4 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                  <h1 class="mb-3 text-center">REGISTER</h1>
                  <div class="alert alert-danger mx-auto p-2 formalert" role="alert" hidden>
                    <p class="m-0">SAMPLE</p>
                  </div>
                  <hr class="mb-1 formhr">
                  <div class="progress mb-3">
                    <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress-bar progress-bar-striped progress-bar-animated" id="progress" role="progressbar">
                      25%
                    </div>
                  </div>
                  <form class="regisform" data-parsley-validate action="{{ route('register') }}" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="form-section">
                      <h6 class="text-center my-2 formhtext">ACCOUNT INFORMATION</h6>
                      <hr class="my-2 mb-4 formhr">
                      <div class="form-group">
                        <label class="form-control-label">Email:</label> 
                        <input type="email" name="email" placeholder="Email Address" class="form-control" data-parsley-trigger="focus" data-parsley-type="email" required>
                      </div>
                      <div class="form-group">       
                        <label class="form-control-label">Password:</label>
                        <input id="password" name="password" type="password" placeholder="Password" class="form-control" required>
                      </div>
                      <div class="form-group">       
                        <label class="form-control-label">Confirm Password:</label>
                        <input type="password" name="password_confirmation" placeholder="Confirm It" class="form-control" data-parsley-equalto="#password" data-parsley-error-message="Please confirm your password" data-parsley-trigger="focus" required>
                      </div>
                    </div>
                    <div class="form-section">
                       <h6 class="text-center my-2 formhtext">PERSONAL INFORMATION</h6>
                      <hr class="my-2 mb-4 formhr">
                      <div class="form-group">
                        <label class="form-control-label">Given Name:</label> 
                        <input autocomplete="off" name="fname" class="form-control" data-parsley-error-message="Invalid! No numbers or special characters" data-parsley-pattern='/^[a-zA-Z\s]*$/' id="fname" name="fname" required="" type="text" value="">
                      </div>
                      <div class="form-group">       
                        <label class="form-control-label">Maiden Name:</label>
                        <input autocomplete="off" name="mname" class="form-control" data-parsley-error-message="Invalid! No numbers or special characters" data-parsley-pattern='/^[a-zA-Z\s]*$/' id="mname" name="mname" required="" type="text" value="">
                      </div>
                      <div class="form-group">       
                        <label class="form-control-label">Surname Name:</label>
                        <input autocomplete="off" name="lname" class="form-control" data-parsley-error-message="Invalid! No numbers or special characters" data-parsley-pattern='/^[a-zA-Z\s]*$/' id="lname" name="lname" required="" type="text" value="">
                      </div>
                    </div>
                    <div class="form-section">
                      <h6 class="text-center my-2 formhtext">PERSONAL INFORMATION</h6>
                      <hr class="my-2 mb-4 formhr">
                      <div class="row px-3">
                        <div class="col-md-6">
                           <label class="form-control-label text-center  w-100">GENDER</label>
                          <div class="custom-controls-stacked">
                            <label class="custom-control custom-radio"><input class="custom-control-input" id="gender1" name="radio-stacked1" type="radio" value="1"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Male</span></label> <label class="custom-control custom-radio"><input class="custom-control-input" data-parsley-error-message="This is required" id="gender2" name="radio-stacked1" required="" type="radio" value="2"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Female</span></label>
                          </div>
                        </div>
                        <div class="col-md-6" style="color:dimgrey;">
                          <label class="form-control-label text-center  w-100">COUNCIL</label>
                          <div class="custom-controls-stacked">
                            <label class="custom-control custom-radio"><input class="custom-control-input" id="C1" name="radio-stacked3" type="radio" value="1"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Academic</span></label> <label class="custom-control custom-radio"><input class="custom-control-input" data-parsley-error-message="This is required" id="C2" name="radio-stacked3" required="" type="radio" value="2"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Administrative</span></label>
                          </div>
                        </div>
                      </div>
                      <div id="fC1" class="mt-3" style="margin-bottom: 20px;">
                        <label class="form-control-label text-center  w-100">ACADEMIC</label>
                        <select class="form-control mb-1 acadsel" style="padding: 0px 15px;" data-parsley-error-message="This is Required" id="college" name="college" required> 
                          <option disabled hidden="" selected value="">
                            Select College
                          </option>
                          <option value="1">
                            College of Arts and Sciences
                          </option>
                          <option value="2">
                            College of Education
                          </option>
                          <option value="3">
                            College of Engineering
                          </option>
                          <option value="4">
                            College of Technology
                          </option>
                          <option value="5">
                            College of Governance and Business
                          </option>
                          <option value="5">
                            Institute of Computing
                          </option>
                          <option value="6">
                            School of Applied Economics
                          </option>
                          <option value="7">
                            College of Development Management
                          </option>
                          <option value="8">
                            College of Agriculture and Related Sciences
                          </option>
                          <option value="9">
                            College of Teacher Education and Technology
                          </option>
                          <option value="10">
                            Bislig Campus
                          </option>
                        </select>
                      </div>
                      <div id="fC2" class="mt-3">
                        <label class="form-control-label text-center w-100">ADMINISTRATIVE</label>
                        <div class="form-group">
                          <label class="form-control-label">Designation:</label> 
                          <input autocomplete="off" class="form-control forminput" data-parsley-error-message="Invalid! No numbers or special characters" data-parsley-pattern='/^[a-zA-Z\s]*$/' id="designation" name="designation" required="" type="text" value="">
                        </div>
                        <div class="form-group">
                          <label class="form-control-label">Office:</label> 
                          <input autocomplete="off" class="form-control forminput" data-parsley-error-message="Invalid! No numbers or special characters" data-parsley-pattern='/^[a-zA-Z\s]*$/' id="office" name="office" type="text" value="">
                        </div>
                      </div>
                    </div>
                    <div class="form-section">
                      <h6 class="text-center my-2 formhtext">PERSONAL INFORMATION</h6>
                      <hr class="my-2 mb-4 formhr">
                      <div class="img w-100">
                        <img id="img" src="">
                        <div id="ititle">
                          <h2 class="m-0 text-center" style="font-weight: 400!important;letter-spacing: 1.5px; word-spacing: 3px;color:snow;"><i aria-hidden="true" class="fa fa-image"></i></h2>
                          <h6 class="text-center mt-2" style="color:snow;font-weight: 300;">Note: We prefer you to upload ".png" image type</h6>
                        </div>
                      </div>
                      <label class="add-photo-btn btn btn-sm btn-block btn-outline-danger text-center mb-0" style="border: 1px solid white; background-color: #933a32; color: white;">Upload Image Signature 
                          <input id="myfile" name="myfile" type="file" hidden>
                      </label>
                      <p class="mb-2" id="filerrormsg">This is required</p>
                    </div>
                     <div class="form-navigation btn-group w-100">
                      <button class="previous btn btn-outline-danger w-50 formoptbtn" type="button">Previous</button> <button class="next btn btn-danger w-100" type="button" value="">Next</button> 
                      <input class="submit btn btn-danger w-100" disabled type="submit" value="Signup">
                    </div>
                  </form>
                  <small>Already have an account? </small><a href="{{ route('login')}}" class="signup">Login</a>
                </div>
              </div>
            </div>
@endsection

@section('script')
    <script>
      $(document).ready(function() {
        var $sections = $('.form-section');
        var flexwidth = 25;
        var errorbool = false;

        function navigateTo(index) {
          // Mark the current section with the class 'current'
          $sections.removeClass('current').eq(index).addClass('current');
          // Show only the navigation buttons that make sense for the current section:
          $('#progress').width( flexwidth + '%');
          $('#progress').html(flexwidth + '%');

          if (index == 0) {
            $('.form-navigation .login').show();
            $('.form-navigation .previous').css('display', 'none');
          } else {
            $('.form-navigation .login').css('display', 'none');
            $('.form-navigation .previous').show();
          }
          var atTheEnd = index >= $sections.length - 1;
          if (!atTheEnd) {
            $('.form-navigation .next').show();
            $('.form-navigation [type=submit]').css('display', 'none');
          } else {
            $('.form-navigation .next').css('display', 'none');
            $('.form-navigation [type=submit]').show();
          }
        }

        function curIndex() {
          // Return the current index by looking at which section has the class 'current'
          return $sections.index($sections.filter('.current'));
        }
        // Previous button is easy, just go back
        $('.form-navigation .previous').click(function() {
          flexwidth -= 25;
          navigateTo(curIndex() - 1);
        });
        // Next button goes forward iff current block validates
        $('.form-navigation .next').click(function() {
          $('.regisform').parsley().whenValidate({
            group: 'block-' + curIndex()
          }).done(function() {
            flexwidth += 25;
            navigateTo(curIndex() + 1);
          });
        });
        // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
        $sections.each(function(index, section) {
          $(section).find(':input').attr('data-parsley-group', 'block-' + index);
        });
        navigateTo(0); // Start at the beginning

        $('#myfile').change(function(event) {
          if (window.File && window.FileReader && window.FileList && window.Blob)
          {
            $('#filerrormsg').css('visibility', 'hidden');
            errorbool = false;
            var file = $('#myfile').val();
            console.log(file.length);
            if ( file.length > 0 ) {
              $('#filerrormsg').css('visibility', 'hidden');
              errorbool = false;
              var fsize = document.getElementById('myfile').files[0].size;
              var ftype = document.getElementById('myfile').files[0].type;
              switch(ftype)
              {
                  case 'image/png':
                  case 'image/jpg':
                  case 'image/jpeg':
                      if(fsize <= 8388608) {
                        errorbool = false;
                        $('#filerrormsg').css('visibility', 'hidden');
                        $('#img').attr("src","");
                        var tmppath = URL.createObjectURL(event.target.files[0]); 
                        $("#ititle").css('display', 'none');
                        $('#img').fadeIn().attr("src",tmppath);
                        $(".submit").prop('disabled', false);
                      }else{
                        errorbool = true;
                        $("#ititle").fadeIn();
                        $("#img").css('display', 'none');
                        $('#filerrormsg').html("The File size is too big");
                        $('#filerrormsg').css('visibility', 'visible');
                        $(".submit").prop('disabled', true);
                      }
                      break;
                  default:
                  errorbool = true;
                  $("#ititle").fadeIn();
                  $("#img").css('display', 'none');
                  $('#filerrormsg').html("Unsupported file document");
                  $('#filerrormsg').css('visibility', 'visible');
                  $(".submit").prop('disabled', true);
              }
            }
            else {
                errorbool = true;
                $("#ititle").fadeIn();
                $("#img").css('display', 'none');
                $('#filerrormsg').html("This is Required");
                $('#filerrormsg').css('visibility', 'visible');
                $(".submit").prop('disabled', true);
            }

          }else{
            errorbool = true;
            $('#filerrormsg').html("Please upgrade your browser, because your current browser lacks some new features we need!");
            $('#filerrormsg').css('visibility', 'visible');
          }
         
        });

        $("#C1").click(function() {
            $("#fC2").slideUp("300", function() { //slide up
              $("#fC1").slideDown("300", function() { 
                $("#office").val("");
                $("#designation").val("");
                $("#designation").prop('required', false);
                $("#office").prop('required', false); 
                $("#college").val($("#college").data("default-value"));
                $("#college").prop('required', true);
              });
            });
        });

        $("#C2").click(function() {
          $("#fC1").slideUp("300", function() { //slide up
            $("#fC2").slideDown("300", function() { 
              $("#office").val("");
              $("#designation").val("");
              $("#office").prop('required', true); 
              $("#designation").prop('required', true);
              $("#college").val($("#college").data("default-value"));
              $("#college").prop('required', false);
            });
          });
        });

      });
    </script>
@endsection