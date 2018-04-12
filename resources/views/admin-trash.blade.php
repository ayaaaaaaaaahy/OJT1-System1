@extends('layouts.admin')

@section('title')
  <title>OSU | Delete Documents</title>
@endsection

@section('a2')
  class="active"
@endsection

@section('content')
<div class="content-inner">
  <ul class="breadcrumb">
            <div class="container-fluid">
              <li class="breadcrumb-item ">Document</li>
              <li class="breadcrumb-item active">Recycle Bin</li>
            </div>
          </ul>
  </ul>
  <!-- Updates Section-->
  <section class="updates pt-0" >
    <div class="container-fluid">
      <div class="row">
        <!-- Recent Updates-->
        @if (count($docs) === 0)
          <div class="col-sm-6 col-md-6 col-lg-4 py-3">
            <p>No Documents!</p>
          </div>
        @endif
        @foreach($docs as $data)
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
                      <button class="mi btn btn-sm btn-outline-primary w-50" data-target="#{{$data->doc_id}}" data-toggle="modal" type="button">Signatories</button>
                      <form class="mb-0" data-parsley-validate="" method="post" action="{{ route('printPDF') }}">
                            {{ csrf_field() }}
                            <button class="mi btn btn-sm btn-danger w-100" id="submit" type="submit" name="print" value="{{ $data->doc_id }}" onClick="loadPDF(this.value)" 
                              @if ($data->totalprogress < 50)
                                  <?php echo 'disabled' ?>
                              @else
                              {
                                  @if (($data->docstatus_name == "Pending") || ($data->docstatus_name == "Disapproved"))
                                  {
                                        <?php echo 'disabled' ?>
                                  }
                                  @endif
                              }
                              @endif
                              >PRINT PDF</button>
                      </form>
                    </div>
                    <hr class="my-2" style="background-color: grey;">
                      <div id="buttonhide">
                        <div class="form-navigation btn-group w-100 my-1">
                          <hr class="my-2" style="background-color: grey;">
                          <div class="form-navigation btn-group w-100 my-1">
                            <button class="btn btn-sm btn-danger w-50 " data-target="#delete_{{$data->doc_id}}" data-toggle="modal" type="button">DELETE</button>
                            <button class="btn btn-sm btn-outline-danger w-50 " data-target="#recover_{{$data->doc_id}}" data-toggle="modal" type="button">RECOVER</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <!-- START of MODAL for permanently deleting or recovering documents -->
                          <form class="mb-0" data-parsley-validate="" method="post" action="{{ route('deleteDocu') }}">
                          {{ csrf_field() }}
                            <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade text-left" id="delete_{{$data->doc_id}}" role="dialog" style="z-index: 10500;" tabindex="-1">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header" style="background-color: #860c23; color: white; display: block;">
                                    <h2 class="cust-h2 mb-0">Permanently Delete Document</h2>
                                  </div>
                                  <div class="modal-body p-1">
                                    <center>
                                      <br>
                                      <h1 style="font-family: 'Segoe UI Light'; font-weight: bold;">WARNING!</h3>
                                      <br>
                                      <h3 style="font-family: 'Segoe UI Light'; font-weight: lighter;">This document has been signed by 
                                        <span style="font-family: 'Segoe UI Light'; font-weight: bold;">{{$data->totalprogress}}%</span> 
                                        of the signatories.
                                        <br>
                                        Deletion of documents is irrevocable.</h3>
                                    </center>
                                    <br>
                                    <center>
                                      <h3 style="font-family: 'Segoe UI Light'; font-weight: lighter;">Are you sure you want to permanently delete <span style="font-family: 'Segoe UI Light'; font-weight: bold;">"{{ $data->doc_title }}"</span>?</h3>
                                    </center>
                                  </div>
                                  <div class="modal-footer p-2">
                                    <button class="btn btn-danger w-50" id="submit" type="submit" name="docID" value="{{ $data->doc_id }}" onClick="loadDeletion(this.value)">DELETE</button>
                                    <button class="btn btn-secondary w-50" data-dismiss="modal" type="button">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>

                          <form class="mb-0" data-parsley-validate="" method="post" action="{{ route('recoverDocu') }}">
                          {{ csrf_field() }}
                            <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade text-left" id="recover_{{$data->doc_id}}" role="dialog" style="z-index: 10500;" tabindex="-1">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header" style="background-color: #860c23; color: white; display: block;">
                                    <h2 class="cust-h2 mb-0">Recover Document</h2>
                                  </div>
                                  <div class="modal-body p-1">
                                    <center>
                                      <br>
                                      <h1 style="font-family: 'Segoe UI Light'; font-weight: lighter;">Are you sure you want to recover 
                                        <span style="font-family: 'Segoe UI Light'; font-weight: bold;">"{{ $data->doc_title }}"</span>
                                      ?</h1>
                                      <br>
                                    </center>
                                  </div>
                                  <div class="modal-footer p-2">
                                    <button class="btn btn-danger w-50" id="submit" type="submit" name="docID" value="{{ $data->doc_id }}" onClick="loadRecovery(this.value)">RECOVER</button>
                                    <button class="btn btn-secondary w-50" data-dismiss="modal" type="button">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                          <!-- End of Modal -->


            <!-- Loading Screen Modal (for deleting documents)-->
                          <div id="loadDeletion_{{$data->doc_id}}" class="col-lg-5 col-md-12 col-xs-3 col-centered" style="display: none; background-color: white;">
                            <br/>
                              <div><center><h1 style="font-family: 'Segoe UI Light','Segoe UI'; font-weight: 300;">Please wait while the system performs deletion of document.</h1></center></div>
                            <br/>
                              <div><center>
                                <img src="{{ asset('img/load.gif') }}" width="75px" height="75px">
                              </div></center>

                            <br/>
                            <br/>
                          </div>
          <!--  End of Loading Screen Modal  -->

          <!-- Loading Screen Modal (for recovering documents)-->
                          <div id="loadRecovery_{{$data->doc_id}}" class="col-lg-5 col-md-12 col-xs-3 col-centered" style="display: none; background-color: white;">
                            <br/>
                              <div><center><h1 style="font-family: 'Segoe UI Light','Segoe UI'; font-weight: 300;">Please wait while the system recovers the document.</h1></center></div>
                            <br/>
                              <div><center>
                                <img src="{{ asset('img/load.gif') }}" width="75px" height="75px">
                              </div></center>

                            <br/>
                            <br/>
                          </div>
          <!--  End of Loading Screen Modal  -->

          <!-- Loading Screen Modal -->
                          <div id="loadpdf_{{$data->doc_id}}" class="col-lg-5 col-md-12 col-xs-3 col-centered" style="display: none; background-color: white;">
                            <br/>
                              <div><center><h1 style="font-family: 'Segoe UI Light','Segoe UI'; font-weight: 300;">Please wait as the system generates the document.</h1></center></div>
                            <br/>
                              <div><center>
                                <img src="{{ asset('img/load.gif') }}" width="75px" height="75px">
                              </div></center>

                            <br/>
                            <br/>
                          </div>
      <!--  End of Loading Screen Modal  -->
          
<!-- START of modal -->
            <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade text-left" id="{{$data->doc_id}}" role="dialog" style="z-index: 10500;" tabindex="-1">
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
                                      <div class="image"><img alt="..." class="img-fluid rounded-circle" src="{{asset('auth/img/avatar-1.jpg')}}"></div>
                                      <div class="text w-100">
                                        <p class="mb-0">{{ $ad->u_fname }}&nbsp;{{ $ad->u_lname }}</p><small><i>{{ $ad->u_fname }} {{ $ad->designation }}, {{ $ad->office }}</i></small>
                                        <hr class="my-1" style="background-color: grey;">
                                        @if($ad->sstat_name == "Accepted")
                                            <small class="btn btn-success btn-sm text-white">{{ $ad->sstat_name }}</small><small> on <?php echo date('F j Y g:i A', strtotime($ad->timestamp)); ?> </small>
                                        @elseif($ad->sstat_name == "Declined")
                                            <small class="btn btn-danger btn-sm text-white">{{ $ad->sstat_name }}</small><small> on <?php echo date('F j Y g:i A', strtotime($ad->timestamp)); ?> </small>
                                        @else
                                            <small class="btn btn-primary btn-sm text-white">{{ $ad->sstat_name }}</small><small> since <?php echo date('F j Y g:i A', strtotime($ad->timestamp)); ?> </small>
                                        @endif
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
                                      <div class="image"><img alt="..." class="img-fluid rounded-circle" src="{{asset('auth/img/avatar-1.jpg')}}"></div>
                                      <div class="text w-100">
                                        <p class="mb-0">{{ $ac->u_fname }} {{ $ac->u_lname }}</p><small><i>{{ $ac->col_name }}</i></small>
                                        <hr class="my-1" style="background-color: grey;">
                                        @if($ac->sstat_name == "Accepted")
                                            <small class="btn btn-success btn-sm text-white">{{ $ac->sstat_name }}</small><small> on <?php echo date('F j, Y g:i A', strtotime($ac->timestamp)); ?> </small>
                                        @elseif($ac->sstat_name == "Declined")
                                            <small class="btn btn-danger btn-sm text-white">{{ $ac->sstat_name }}</small><small> on <?php echo date('F j, Y g:i A', strtotime($ac->timestamp)); ?> </small>
                                        @else
                                            <small class="btn btn-primary btn-sm text-white">{{ $ac->sstat_name }}</small><small> since <?php echo date('F j, Y g:i A', strtotime($ac->timestamp)); ?> </small>
                                        @endif
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
        </div>
        @endforeach

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
          function loadDeletion(value) //loading screen upon clicking DELETE
          {
              var temp = value;
              var modalName = "#loadDeletion_" + temp;

              $(modalName).show();

              console.log(modalName);

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
          }

          function loadRecovery(value) //loading screen upon clicking RECOVER
          {
              var temp = value;
              var modalName = "#loadRecovery_" + temp;

              $(modalName).show();

              console.log(modalName);

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
          }

          function loadPDF(value) //loading screen for PRINT PDF button
          {
              var temp = value;
              var modalName = "#loadpdf_" + temp;

              $(modalName).show();

              console.log(modalName);

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
          }
      </script>
      </script>

@endsection