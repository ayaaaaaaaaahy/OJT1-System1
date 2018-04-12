<meta http-equiv="Content-Type" content="charset=utf-8" />
<meta charset="UTF-8">
  
  <style>
      table, td{ border: 1px solid black; }
      th { background-color: maroon; color: white; border: 1px solid maroon; }
      @page 
      {
            margin-top: 55px;
            margin-bottom: 65px;
      }
      #rotated
      {
         -webkit-transform: rotate(-90deg); 
         -moz-transform: rotate(-90deg);    
      }
  </style>


  <div style="position: fixed; top: -40px; left: 0px; right: 0px; border-left: solid black 3px; width: 100%; height: 35px;">
      <h6 style="font-family: Helvetica; font-weight: lighter; margin-top: 5px;">&nbsp;{{ $docu }}</h6>
      <h6 style="font-family: Helvetica; font-weight: lighter; margin-top: -25px;">&nbsp;Signatories</h6>
  </div>

  <div style="position: fixed; top: 390px; left: -40px; right: 0px; width: 40px; height: 100%;">
      <img style="width: 35px; height: 250px;" src="<?php echo public_path() ?>/temp/barcode_temp.png">
  </div>

  <h6 style="position: absolute; top: -400px; left: -775px; right: 0px; font-family: Helvetica; font-weight: lighter;" id="rotated">&nbsp;Printed on: {{ $date }}</h6>

  <div style="position: fixed; bottom: 12px; left: 0px; right: 0px;"><center><img style="width: 720px; height: 150%;" src="<?php echo public_path() ?>/img/footer.png"></center></div>


  @if($admin > 0)
        <table style="border-collapse: collapse; width:100%;">
              <tr>
                <th colspan="2"><center>Administrative Council Members</center></th>
                <th><center>Approved</center></th>
                <th><center>Disapproved</center></th>
              </tr>
        @foreach($info as $data)
        @if($data->c_id === 2)
              <tr>
                <td width="25%"><center>{{ $data->u_fname }}&nbsp;{{ $data->u_mname }}&nbsp;{{ $data->u_lname }}</center></td>
                <td width="35%"><center>{{ $data->office }},&nbsp;{{ $data->designation }}</center></td>
                @if ($data->sstat_id == 1)
                  <td width="20%"><center><img style="width: 100px; height: 50px;" src="<?php echo public_path() ?>{{$data->u_signature}}"></center></td>
                  <td width="20%"></td>
                @elseif ($data->sstat_id == 2)
                  <td width="20%"></td>
                  <td width="20%"><center><img style="width: 100px; height: 50px;" src="<?php echo public_path() ?>{{$data->u_signature}}"></center></td>
                @else
                  <td width="20%"><img style="width: 100px; height: 50px;" src="<?php echo public_path() ?>/img/blank.png"></td>
                  <td width="20%"></td>
                @endif
              </tr>
        @endif
        @endforeach
        </table>
        <br/>
  @endif


  @if($acad > 0)
        <table style="border-collapse: collapse; width:100%;">
              <tr>
                <th colspan="2"><center>Academic Council Members</center></th>
                <th><center>Approved</center></th>
                <th><center>Disapproved</center></th>
              </tr>
        @foreach($info as $data)
        @if($data->c_id === 1)
              <tr>
                <td width="25%"><center>{{ $data->u_fname }}&nbsp;{{ $data->u_mname }}&nbsp;{{ $data->u_lname }}</center></td>
                <td width="35%"><center>{{ $data->col_name }}</center></td>
                @if ($data->sstat_id == 1)
                  <td width="20%"><center><img style="width: 100px; height: 50px;" src="<?php echo public_path() ?>{{$data->u_signature}}"></center></td>
                  <td width="20%"></td>
                @elseif ($data->sstat_id == 2)
                  <td width="20%"></td>
                  <td width="20%"><center><img style="width: 100px; height: 50px;" src="<?php echo public_path() ?>{{$data->u_signature}}"></center></td>
                @else
                  <td width="20%"><img style="width: 100px; height: 50px;" src="<?php echo public_path() ?>/img/blank.png"></td>
                  <td width="20%"></td>
                @endif
              </tr>
         @endif
        @endforeach
        </table>
  @endif

  <div style="page-break-after: always;" hidden>
  </div>