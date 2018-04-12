@extends('layouts.admin')

@section('title')
  <title>OSU | User History</title>
@endsection

@section('a4')
  class="active"
@endsection

@section('content')
<div class="content-inner">
  <ul class="breadcrumb">
    <div class="container-fluid">
      <li class="breadcrumb-item ">History</li>
      <li class="breadcrumb-item active">User History</li>
    </div>
  </ul>
  <section class="forms py-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card my-3">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Users</h3>
            </div>
            <div class="card-body p-2" style="height: 700px;overflow: auto;">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Office/College</th>
                    <th class="text-center">Council</th>
                    <th class="text-center">Account Status</th>
                    <th class="text-center">When</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $id = 1; ?>
                  @foreach($docs as $data)
                  <tr>
                    <td class="p-2" style="vertical-align: middle;width: 5%">
                      <p class="mb-0 py-auto text-center"><?php echo $id++; ?></p>
                    </td>
                    <td class="p-2" style="vertical-align: middle; width:17%">
                      <p class="mb-0 py-auto text-center">{{ $data->u_fname }} {{ $data->u_mname }} {{ $data->u_lname }}</p>
                    </td>
                    @if ($data->c_id == 2)
                      <td class="p-2" style="vertical-align: middle; width:17%">
                        <p class="mb-0 py-auto text-center">{{ $data->designation }}, {{ $data->office }}</p>
                      </td>
                    @elseif ($data->c_id == 1)
                      <td class="p-2" style="vertical-align: middle; width:17%">
                        <p class="mb-0 py-auto text-center">{{ $data->col_name }}</p>
                      </td>
                    @endif
                    <td class="p-2" style="vertical-align: middle; width:17%">
                      <p class="mb-0 py-auto text-center">{{ $data->c_name }}</p>
                    </td>
                    <td class="p-2" style="vertical-align: middle; width:17%">
                      <p class="mb-0 py-auto text-center">{{ $data->astat_name }}</p>
                    </td>
                    <td class="p-2" style="vertical-align: middle; width:17%">
                      <p class="mb-0 py-auto text-center"><?php echo date('F j, Y g:i A', strtotime($data->timestamp)); ?></p>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection