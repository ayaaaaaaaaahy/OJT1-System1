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