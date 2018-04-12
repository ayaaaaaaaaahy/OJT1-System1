@extends('layouts.admin')

@section('title')
  <title>OSU | Upload Document</title>
@endsection

@section('a2')
  class="active"
@endsection

@section('content')
        <div class="content-inner">
         <ul class="breadcrumb">
            <div class="container-fluid">
              <li class="breadcrumb-item ">Document</li>
              <li class="breadcrumb-item active">Upload Option</li>
            </div>
          </ul>
         <section class="forms py-0"> 
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <form id="uploadform" class="form-horizontal" data-parsley-validate="" method="post" action="{{ route('upload') }}" enctype="multipart/form-data">
                     {{ csrf_field() }}
                  <div class="card my-3">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4"> Information</h3>
                    </div>
                    <div class="card-body">
                      @if(session()->has('status'))
                        @if (session('status'))
                          <div class="alert alert-success mx-auto p-2 formalert" role="alert">
                           {{ session('status') }}
                           {{ session()->forget('status') }}
                          </div>
                        @endif
                      @endif
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Document Title</label>
                        <div class="col-sm-9">
                          <input type="text" name="doc_title" class="form-control" data-parsley-trigger="focusin focusout" data-parsley-error-message="This field is required." required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Document Type</label>
                          <div class="col-sm-9">
                            <input type="text" name="doc_type" class="form-control" data-parsley-trigger="focusin focusout" data-parsley-error-message="This field is required." required>
                          </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Document Description</label>
                          <div class="col-sm-9">
                            <input type="text" name="doc_desc" class="form-control" data-parsley-trigger="focusin focusout" data-parsley-error-message="This field is required." required>
                          </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Document Deadline</label>
                          <div class="col-sm-9">
                            <input id="thedate" type="date" min="<?php echo date('Y-m-d', strtotime('tomorrow')); ?>" name="doc_deadline" class="form-control" data-parsley-trigger="focusin focusout" data-parsley-type="date" data-parsley-required-message="This field is required" required>
                          </div>
                      </div>
                       <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Document File</label>
                          <div class="col-sm-9">
                            <input id="myfile" type="file" name="doc_file" data-parsley-fileextension='pdf' data-parsley-maxfilesize="10" class="form-control" data-parsley-trigger="focusin focusout" data-parsley-required-message="This field is required" required >
                          </div>
                      </div>
                      <div class="line my-4"></div>
                      
                      <div class="form-group row">
                        <label class="col-md-12 form-control-label text-center mb-0" style="font-size: 20px;">SIGNATORIES</label>
                          <div id="cont" class="col-12">                            
                          </div>
                          @if (count($data) >= 0)      

                          <div class="col-md-6">  
                            <fieldset>
                            <div class="item d-flex align-items-center py-2 text-center">
                              <div class="px-2">
                                <input id="ADCcheckall" type="checkbox" class="checkbox-template ADCcheckall" >
                              </div>
                              <div class="text w-100 px-2">
                                <h5 class="mb-0" style="font-weight: 300;">Administrative Council</h5>
                              </div>
                            </div>
                            <hr class="my-1">                            
                            <div style="height: 500px; overflow: auto;">
                              @foreach($data as $data) 
                                @if($data->c_name == 'Administrative Council')
                                @if($data->id != $user_id)
                                  <div class="item d-flex align-items-center py-2">
                                    <div class="px-2">
                                      <input id="{{ $data->id }}" type="checkbox" name="{{ $data->id }}" value="{{ $data->id }}" class="checkbox-template ADcheck">
                                    </div>
                                    <div class="image px-1">
                                      <img src="{{ asset('auth/img/avatar-1.jpg') }}" width="75px" height="75px" alt="..." class="img-fluid rounded-circle">
                                    </div>
                                    <div class="text w-100 px-2">
                                      <h5 class="mb-0" style="font-weight: 300;">{{ $data->u_fname }} {{ $data->u_lname }}</h5>
                                      <hr class="my-1">
                                      <small class="mb-0" style="font-weight: 300;">{{ $data->designation }}, {{ $data->office }}</small>
                                    </div>
                                  </div>
                                @endif
                                @endif
                              @endforeach
                            </div>
                            </fieldset>
                          </div>      

                          <div class="col-md-6">
                            <fieldset>                              
                            <div class="item d-flex align-items-center py-2 text-center">                              
                              <div class="px-2">
                                <input id="ACcheckall" type="checkbox" class="checkbox-template ACcheckall">
                              </div>
                              <div class="text w-100 px-2">
                                <h5 class="mb-0" style="font-weight: 300;">Academic Council</h5>
                              </div>
                            </div>
                             <hr class="my-1">                            
                            <div style="height: 500px; overflow: auto;">
                              @foreach($info as $data)
                                @if($data->c_name == 'Academic Council')
                                @if($data->id != $user_id)
                                <div class="item d-flex align-items-center py-2">
                                  <div class="px-2">
                                      <input id="{{ $data->id }}" type="checkbox" name="{{ $data->id }}" value="{{ $data->id }}" class="checkbox-template ADcheck">
                                    </div>
                                  <div class="image px-1">
                                    <img src="{{ asset('auth/img/avatar-1.jpg') }}" width="75px" height="75px" alt="..." class="img-fluid rounded-circle">
                                  </div>
                                  <div class="text w-100 px-2">
                                    <h5 class="mb-0" style="font-weight: 300;">{{ $data->u_fname }} {{ $data->u_lname }}</h5>
                                    <hr class="my-1">
                                    <small class="mb-0" style="font-weight: 300;">{{ $data->col_name }}</small>
                                  </div>
                                </div>
                                @endif
                                @endif
                              @endforeach
                            </div>                            
                            </fieldset>
                          </div>   

                          @endif

                          <!-- Loading Screen Modal -->
                          <div id="myModal" class="col-lg-5 col-md-12 col-xs-3 col-centered" style="display: none; background-color: white;">
                            <br/>
                              <div><center><h1 style="font-family: 'Segoe UI Light','Segoe UI'; font-weight: 300;">Please wait for a few moments.</h1></center></div>
                            <br/>
                              <div><center>
                                <img src="{{ asset('img/load.gif') }}" width="75px" height="75px">
                              </div></center>

                            <br/>
                            <br/>
                          </div>
                          <!--  End of Loading Screen Modal  -->

                      </div>                     
                      <div class="line my-4"></div>
                      <div class="form-navigation btn-group w-100 my-1">
                        <input id="submit" type="submit" value="SUBMIT" class="mi btn btn-danger w-50" disabled> 
                        <button id="cancel" class="mi btn btn-outline-danger w-50" type="button" value="">CANCEL</button> 
                      </div>
                    </div>
                  </div> 
                  </form>
                </div>
              </div>
            </div>
          </section>
        </div>
@endsection

@section('script')
    <script>

    $('.ADCcheckall').on('click', function () {
      $(this).closest('fieldset').find(':checkbox').prop('checked', this.checked);
    });

    $('.ACcheckall').on('click', function () {
      $(this).closest('fieldset').find(':checkbox').prop('checked', this.checked);
    }); 

    $('#cancel').on('click', function () {
      $('#uploadform').trigger("reset");
      $('#submit').attr('disabled', true);
    });

    

    $('#uploadform').on('submit', function () {
      
      $('#myModal').show();

      new Custombox.modal({
        content: {
            target: '#myModal',
            effect: 'blur',
            positionX: 'center',
            positionY: 'center',
            close: false,
        },
        overlay: {
            active: true,
            color: '#000',
            opacity: .2,
            close: false,
        }
        }).open();

    });

    //input validation to enable submit button

    var proceed = 0;

    $('input').on("change keyup paste click", function(){

              $('input[type="text"]').each(function() {
                  if ($(this).val() == '') 
                  {
                      proceed = 0;
                  }
                  else
                  {
                      proceed++;
                  }
              });

              if ($('input[type="checkbox"]:checked').length > 0)
              {
                  proceed++;
              }
              else
              {
                  proceed = 0;
              }

              if ($('#myfile').val() == '') 
              {
                  proceed = 0;
              }
              else
              {
                  proceed++;
              }

              if ($('#thedate').val() == '') 
              {
                  proceed = 0;
              }
              else
              {
                  proceed++;
              }

              if (proceed > 5) 
              {
                  $('#submit').removeAttr('disabled'); 
              } 
              else 
              {
                  $('#submit').attr('disabled', true);
              }
        });

    //end of validation

    window.Parsley
      .addValidator('fileextension', function (value, requirement) {
        // the value contains the file path, so we can pop the extension
        var fileExtension = value.split('.').pop();
          return fileExtension === requirement;
      }, 32)
      .addMessage('en', 'fileextension', 'The extension doesn\'t match the required');
    $("#uploadform").parsley();

    window.Parsley.addValidator('maxfilesize', {
      validateString: function(_value, maxSize, parsleyInstance) {
        var files = parsleyInstance.$element[0].files;
        return files.length != 1  || files[0].size <= 10485760;
      },
      requirementType: 'integer',
      messages: {
        en: 'This file should not be larger than %s Mb',
      }
    });
    </script>
@endsection