@extends('layouts.user')

@section('title')
  <title>OSU | User Dashboard</title>
@endsection

@section('a1')
  class="active"
@endsection

@section('content')
<div class="content-inner">
  <!-- Updates Section                                                -->
  <section class="updates pt-0">
    <div class="container-fluid">

      <div class="row">
        <!-- Recent Updates-->
        @if (count($data) === 0)
          <div class="col-sm-6 col-md-6 col-lg-4 py-3">
            <p>No Documents!</p>
          </div>
        @endif
        
        @foreach($data as $data)
        <div class="col-sm-6 col-md-6 col-lg-4 py-3">
          <div class="recent-updates card">
            <div class="card-header cust-ch">
              <h2 class="cust-h2 mb-0">{{$data->doc_title}}</h2>
              <hr class="cust-hr my-2">
              <h5 class="cust-h5 mb-0"><i>{{$data->doc_type}}</i></h5>
            </div>
            <div class="card-body no-padding">

              <!-- Item-->
              <div class="item">
                <div class="info">
                  <div class="title">
                    <p class="mb-3 cust-dd">{{$data->doc_desc}}</p>
                    <h3 class="my-2"></h3>
                    <p class="mb-2 cust-de">DEADLINE: <span><?php echo date('F j, Y', strtotime($data->doc_deadline)); ?></span></p>
                    <h3 class="my-2"></h3>
                    <p class="mb-2 cust-stat">STATUS: <span>{{$data->docstatus_name}}</span></p>
                    <p class="cust-prog">PROGRESS: <span>{{$data->totalprogress}}%</span></p>
                    <div class="progress my-1 mi">
                      <div aria-valuemax="100" aria-valuemin="0" class="progress-bar progress-bar-striped progress-bar-animated" id="progress" role="progressbar" style="width: {{$data->totalprogress}}%;"></div>
                    </div>
                    <div class="form-navigation btn-group w-100 my-1">
                      <a class="mi btn btn-sm btn-primary w-50" href="{{$data->doc_file}}">PDF</a>
                      <button class="mi btn btn-sm btn-outline-primary w-50" data-target="#{{ $data->doc_id }}" data-toggle="modal" type="button">Signatories</button>
                    </div>
                    <hr class="my-2" style="background-color: grey;">
                    <div id="buttonhide">
                      <div class="form-navigation btn-group w-100 my-1">
                        <button class="mi btn btn-danger w-100" data-target="#keycode{{ $data->doc_id }}" data-toggle="modal" type="button" value="{{ $data->doc_id }}">ACTION</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        

<!-- START of modal -->
          <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade text-left" id="{{ $data->doc_id }}" role="dialog" style="z-index: 10500;" tabindex="-1">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #860c23; color: white; display: block;">
                    <h2 class="cust-h2 mb-0">{{ $data->doc_title }}</h2>
                    <hr class="cust-hr my-2">
                    <h5 class="cust-h5 mb-0"><i>{{ $data->doc_type }}</i></h5>
                  </div>
                  <div class="modal-body p-1">
                    <section class="feeds no-padding-top no-padding-bottom">
                      <div class="container-fluid px-3">
                        <div class="row py-2">
                          <!-- Trending Articles-->
                          <div class="col-md-6 px-1">
                            <div class="articles card">
                              <div class="card-header d-flex align-items-center">
                                <h4 class="mb-0 text-center w-100" style="font-weight: 300;">ADMINISTRATIVE COUNCIL</h4>
                              </div>
                              <div class="card-body no-padding" style="height: 350px; overflow: auto;">
                                @foreach($admin as $ad)
                                  @if($ad->doc_id == $data->doc_id)
                                    <div class="item d-flex align-items-center py-2">
                                      <div class="text w-100">
                                        <p class="mb-0">{{ $ad->u_fname }}&nbsp;{{ $ad->u_lname }}</p><small><i>{{ $ad->u_fname }} {{ $ad->designation }}, {{ $ad->office }}</i></small>
                                      </div>
                                    </div>
                                  @endif
                                @endforeach
                              </div>
                            </div>
                          </div><!-- Check List -->
                          <div class="col-md-6 px-1">
                            <div class="articles card">
                              <div class="card-header d-flex align-items-center">
                                <h4 class="mb-0 text-center w-100" style="font-weight: 300;">ACADEMIC COUNCIL</h4>
                              </div>
                              <div class="card-body no-padding" style="height: 350px; overflow: auto;">
                                @foreach($acad as $ac)
                                  @if($ac->doc_id == $data->doc_id)
                                    <div class="item d-flex align-items-center py-2">
                                      <div class="text w-100">
                                        <p class="mb-0">{{ $ac->u_fname }} {{ $ac->u_lname }}</p><small><i>{{ $ac->col_name }}</i></small>
                                      </div>
                                    </div>
                                  @endif
                                @endforeach
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                  </div>
                  <div class="modal-footer p-2">
                    <button class="btn btn-secondary w-100" data-dismiss="modal" type="button">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- END of modal -->

@endforeach

<!--KEYCODE MODAL -->

@foreach($keycodeData as $data)

<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade text-left" id="keycode{{ $data->doc_id }}" role="dialog" style="z-index: 10500;" tabindex="-1">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #860c23; color: white; display: block;">
                    <h2 class="cust-h2 mb-0">{{ $data->doc_title }}</h2>
                    <hr class="cust-hr my-2">
                    <h5 class="cust-h5 mb-0"><i>Your keycode for this document has been sent to you via email.</i></h5>
                  </div>
                  <div class="modal-body p-1">
                    <section class="feeds no-padding-top no-padding-bottom">
                      <div class="container-fluid px-3">
                        <center>
                          <input class="mi btn btn-outline-danger w-50" type="text" name="keycode" id="user_passcode{{ $data->doc_id }}" required>
                          <input value="{{ $data->doc_id  }}" name="doc" hidden>
                          <input value="{{ $data->u_dockeycode }}" id="passcode{{ $data->doc_id }}" hidden>
                        </center>
                      </div>
                      <hr class="my-1"> 
                      <div id="buttonhide">
                      <div class="form-navigation btn-group w-100 my-1">
                        <button class="mi btn btn-danger w-50" data-target="#accept_{{ $data->doc_id }}" data-toggle="modal" name="ACCEPT" value="{{ $data->doc_id }}" onClick="getID(this.value)">ACCEPT</button>
                        <button class="mi btn btn-outline-danger w-50" data-target="#reject_{{ $data->doc_id }}" data-toggle="modal" name="DECLINE" value="{{ $data->doc_id }}" onClick="getID(this.value)">DECLINE</button>
                        <button class="mi btn btn-outline-danger w-50" data-dismiss="modal" type="button">CLOSE</button>
                      </div>
                    </div>
                    </section>
                  </div>
            </div>
        </div>      
      </div>

      <!-- Loading Screen Modal -->
                          <div id="load_{{$data->doc_id}}" class="col-lg-5 col-md-12 col-xs-3 col-centered" style="display: none; background-color: white;">
                            <br/>
                              <div><center><h1 style="font-family: 'Segoe UI Light','Segoe UI'; font-weight: 300;">Please wait for a few moments.</h1></center></div>
                            <br/>
                              <center>
                                <div>
                                  <img src="{{ asset('img/load.gif') }}" width="75px" height="75px">
                                </div>
                              </center>
                            <br/>
                            <br/>
                          </div>
      <!-- End of Loading Screen-->

      <form id="userDecisionForm{{ $data->doc_id }}" class="mb-0" data-parsley-validate="" method="post" action="{{ route('acceptdoc') }}">
              {{ csrf_field() }}

      <!-- Modal for checkpoint (accept option) -->
      <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade text-left" id="accept_{{$data->doc_id}}" role="dialog" style="z-index: 10500;" tabindex="-1">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header" style="background-color: #860c23; color: white; display: block;">
                                <h2 class="cust-h2 mb-0">Accept Document</h2>
                                  </div>
                                  <div class="modal-body p-1">
                                    <center>
                                    <br>
                                    <h2 style="font-family: 'Segoe UI Light'; font-weight: lighter;">Are you sure you want to accept the 
                                      <span style="font-family: 'Segoe UI'; font-size: 25px;">"{{ $data->doc_title }}"</span> document?
                                    </h2>
                                    <br>
                                  </center>
                                  </div>
                                  <div class="form-navigation btn-group w-100 my-1">
                                    <button class="btn btn-danger w-50" id="submit" type="submit" name="ACCEPT" value="{{ $data->doc_id }}">ACCEPT</button>
                                    <button class="btn btn-secondary w-50" data-dismiss="modal" type="button">Close</button>
                                  </div>
                              </div>
                            </div>
                         </div>
      <!-- Endof checkpoint modal (accept option) -->

      <!-- Modal for checkpoint (reject option) -->
      <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade text-left" id="reject_{{$data->doc_id}}" role="dialog" style="z-index: 10500;" tabindex="-1">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header" style="background-color: #860c23; color: white; display: block;">
                                <h2 class="cust-h2 mb-0">Decline Document</h2>
                                  </div>
                                  <div class="modal-body p-1">
                                    <center>
                                    <br>
                                    <h2 style="font-family: 'Segoe UI Light'; font-weight: lighter;">Are you sure you want to decline the 
                                      <span style="font-family: 'Segoe UI'; font-size: 25px;">"{{ $data->doc_title }}"</span> document?
                                    </h2>
                                    <br>
                                  </center>
                                  </div>
                                  <div class="form-navigation btn-group w-100 my-1">
                                    <button class="btn btn-danger w-50" id="submit" type="submit" name="DECLINE" value="{{ $data->doc_id }}">DECLINE</button>
                                    <button class="btn btn-secondary w-50" data-dismiss="modal" type="button">Close</button>
                                  </div>
                              </div>
                            </div>
                         </div>
      <!-- Endof checkpoint modal (reject option) -->

    </form>

      
      
@endforeach
      
      

      <!--END OF KEYCODE MODAL -->

      <!-- END Recent Updates-->
      
    </div>
      
      
    </div>
  </section>
</div>
@endsection

@section('modal')
@endsection

@section('script')
  
    <script>

      function getID(the_id)   //get id sa document kung asa magdecide si signatory haha (upon clicking ACTION button)
      {
          myId = the_id;
          formName = '#userDecisionForm' + myId;

          $(window.formName).on("submit", function ()   //diria dapit ang error detection para UX-friendly si systemone
          {
                var temp = myId;
                var inputname1 = "#passcode" + temp;
                var inputname2 = "#user_passcode" + temp;

                var passCode = $(inputname1).val();
                var userPasscode = $(inputname2).val();

                if (userPasscode != "" || (userPasscode.indexOf(" ") != -1))
                {
                      if (passCode != userPasscode)
                      {
                            swal("Wrong Passcode", "You may have typed it incorrectly. Please try again.", "error");
                            return false;
                      }
                      else
                      {     
                            var modalName = "#load_" + temp;

                                  $(modalName).show();

                                  new Custombox.modal({
                                  content: {
                                      target: modalName,
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

                            return true;
                      }
                }
                
                swal("Wrong Passcode", "You haven't typed anything. Please try again.", "error");
                return false;
                
           });
      } 

    </script>

@endsection