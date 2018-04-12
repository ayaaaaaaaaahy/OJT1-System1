@extends('layouts.admin')

@section('title')
  <title>OSU | Disable Users</title>
@endsection


@section('a3')
  class="active"
@endsection

@section('content')
<div class="content-inner">
  <ul class="breadcrumb">
    <div class="container-fluid">
      <li class="breadcrumb-item ">User</li>
      <li class="breadcrumb-item active">Disable Option</li>
    </div>
  </ul>
  <section class="forms py-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card my-3 mb-0">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Disable User</h3>
            </div>
            @if (count($data) === 0)
              <div class="col-sm-6 col-md-6 col-lg-4 py-3">
                <p>No Pending Users!</p>
              </div>
            @endif
            <form class="mb-0" data-parsley-validate="" method="post" action="{{ route('disableuser') }}">
              {{ csrf_field() }}

            @foreach($data as $data)
            @if($data->id != $user_id)
            <div class="card-body p-2">
              <div class="form-group row">
                <div class="col-md-12">
                  <!--<div class="item d-flex align-items-center py-2 text-center">
                    <div class="text w-100 px-2">
                      <h5 class="mb-0" style="font-weight: 300;">Administrative Council</h5>
                    </div>
                  </div>-->
                  <div style="height: auto; overflow: auto;">
                    <div class="item d-flex align-items-center py-2">
                      <div class="image px-1"><img alt="..." class="img-fluid rounded-circle" height="150px" src="{{ asset('auth/img/avatar-1.jpg') }}" width="150px"></div>
                      <div class="text w-100 px-2">
                        <h5 class="mb-0" style="font-weight: 300;">{{ $data->u_fname }}&nbsp;{{ $data->u_lname }}</h5>
                        <hr class="my-1">
                        <small class="mb-0" style="font-weight: 300;">
                          {{ $data->col_name }} 
                          @if($data->designation != null)
                            {{ $data->designation }},&nbsp;{{ $data->office }}
                          @endif
                        </small> 
                        <button class="mi mt-2 btn btn-sm btn-info w-100" data-target="#{{ $data->id }}" data-toggle="modal" type="button">More Info</button>
                        <div class="form-navigation btn-group w-100 my-1">
                        <button class="mi btn btn-sm btn-outline-danger w-100 " data-target="#disable_{{$data->id}}" data-toggle="modal" type="button">Disable</button>
                        </div>
                      </div>
                    </div>

                    <!-- START of MODAL for deleting users -->
                      <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade text-left" id="disable_{{$data->id}}" role="dialog" style="z-index: 10500;" tabindex="-1">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header" style="background-color: #860c23; color: white; display: block;">
                              <h2 class="cust-h2 mb-0">Disable User</h2>
                                </div>
                                <div class="modal-body p-1">
                                  <center>
                                    <br>
                                    <h2 style="font-family: 'Segoe UI Light'; font-weight: lighter;">Are you sure you want to disable the account of 
                                      <span style="font-family: 'Segoe UI'; font-size: 25px;">"{{ $data->u_fname }}&nbsp;{{ $data->u_lname }}"</span>?
                                    </h2>
                                    <br>
                                  </center>
                                </div>
                                <div class="modal-footer p-2">
                                  <button class="mi btn btn-danger w-50" id="submit" type="submit" name="DISABLE" value="{{ $data->id }}" onClick="loadThis(this.value)">DISABLE</button>
                                <button class="btn btn-secondary w-50" data-dismiss="modal" type="button">Close</button>
                              </div>
                            </div>
                          </div>
                       </div>
                   <!-- End of Modal -->

                   <!-- Loading Screen Modal -->
                          <div id="load_{{$data->id}}" class="col-lg-5 col-md-12 col-xs-3 col-centered" style="display: none; background-color: white;">
                            <br/>
                              <div><center><h1 style="font-family: 'Segoe UI Light','Segoe UI'; font-weight: 300;">Please wait as the system disables the selected user.</h1></center></div>
                            <br/>
                              <div><center>
                                <img src="{{ asset('img/load.gif') }}" width="75px" height="75px">
                              </div></center>

                            <br/>
                            <br/>
                          </div>
                   <!--  End of Loading Screen Modal  -->

                  </div>
                </div>
              </div>
            </div>
            @endif
            @endforeach
          </div>
        </div>

        @foreach($modal as $data)
        <!--Modal-->
        <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade text-left" id="{{ $data->id }}" role="dialog" style="z-index: 10500;" tabindex="-1">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header" style="background-color: #860c23; color: white; display: block;">
                <h2 class="cust-h2 mb-0">{{ $data->u_fname }}&nbsp;{{ $data->u_lname }} - Information</h2>
              </div>
              <div class="modal-body p-1">
                <section class="feeds no-padding-top no-padding-bottom">
                  <div class="container-fluid px-3">
                    <!-- Trending Articles-->
                    <div class="client card">
                      <div class="row">
                        <div class="col-md-4 px-1">
                          <div class="card-body text-center" style="min-height: 275px; max-height: fit-content;">
                            <div class="client-avatar"><img alt="..." class="img-fluid rounded-circle" src="{{ asset('auth/img/avatar-1.jpg') }}" width="200px"></div>
                            <div class="client-title">
                              <h3>{{ $data->u_fname }}&nbsp;{{ $data->u_lname }}</h3>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-8 px-1">
                          <div class="card-body" style="min-height: 275px; max-height: fit-content;">
                            <div class="row">
                              <label class="col-md-3">Email:</label> <label class="col-md-8" style="font-weight: 300; font-size: 14px;">{{ $data->email }}</label>
                            </div>
                            <div class="row">
                              <label class="col-md-3 mb-0">Gender:</label> <label class="col-md-8 mb-0" style="font-weight: 300; font-size: 14px;">{{ $data->ugen_name }}</label>
                            </div>
                            <hr>
                            <div class="row">
                              <label class="col-md-3">Council:</label> <label class="col-md-8" style="font-weight: 300; font-size: 14px;">{{ $data->c_name }}</label>
                            </div>

                            @if($data->c_name == "Administrative Council")
                              <div class="row">
                                <label class="col-md-3">Designation:</label> <label class="col-md-8" style="font-weight: 300; font-size: 14px;">{{ $data->designation }}</label>
                              </div>
                              <div class="row">
                                <label class="col-md-3">Office:</label> <label class="col-md-8" style="font-weight: 300; font-size: 14px;">{{ $data->office }}</label>
                              </div>
                            @elseif ($data->c_name == "Academic Council")
                              <div class="row">
                                <label class="col-md-3">College:</label> <label class="col-md-8" style="font-weight: 300; font-size: 14px;">{{ $data->col_name }}</label>
                              </div>
                            @endif

                            @if($data->utype_name == "Admin")
                              <div class="row">
                                <label class="col-md-3">User Type:</label> <label class="col-md-8" style="font-weight: 300; font-size: 14px;">Administrator</label>
                              </div>
                            @elseif ($data->utype_name == "User")
                              <div class="row">
                                <label class="col-md-3">User Type:</label> <label class="col-md-8" style="font-weight: 300; font-size: 14px;">{{ $data->utype_name }}</label>
                              </div>
                            @endif
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
        <!--End of Modal-->   

        @endforeach
        
      </form>
    </div>
  </div>
</div>
</div>
</section>
</div>
@endsection

@section('script')
  
    <script>
          function loadThis(value) //loading screen for TRASH button
          {
              var temp = value;
              var modalName = "#load_" + temp;

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

@endsection