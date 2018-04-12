<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Auth;
use DB;
use Redirect;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()    
    {
        if(Auth::user()->u_accstatus == 'approved'){
            //dd('approved');
            //Redirect::back()->withErrors('Unapproved');
        }
        if(Auth::user()->utype_id == 1){

                $dataOnDocs = DB::select("
                    SELECT a.doc_id, a.doc_title, a.doc_type, a.doc_desc, a.doc_file, a.doc_deadline, c.totalprogress, d.docstatus_name
                    FROM document AS a
                    left join document_status_log AS c
                    ON (c.doc_id = a.doc_id)
                    left join document_status AS d
                    ON (c.docstatus_id = d.docstatus_id)
                    WHERE c.docstatus_id != 4
                    GROUP BY a.doc_id, a.doc_title, a.doc_type, a.doc_desc, a.doc_file, a.doc_deadline, c.totalprogress, d.docstatus_name
                    ");

                //dd($dataOnDocs);

                $dataOnAcad = DB::select("
                    SELECT a.doc_id, b.u_id, e.u_fname, e.u_mname, e.u_lname, g.c_name, h.col_name, i.sstat_name, b.timestamp
                    FROM document AS a
                    left join document_signatories AS b
                    ON (a.doc_id = b.doc_id)
                    left join users AS e
                    ON (e.id = b.u_id)
                    left join council_info AS f
                    ON (e.id = f.u_id)
                    left join council AS g
                    ON (f.c_id = g.c_id)
                    left join college AS h
                    ON (f.col_id = h.col_id)
                    left join signatories_status AS i
                    ON (b.sstat_id = i.sstat_id)
                    WHERE g.c_name = 'Academic Council'
                    order by a.doc_id
                    ");

                //dd($dataOnAcad);

                $dataOnAdmin = DB::select("
                    SELECT a.doc_id, b.u_id, e.u_fname, e.u_mname, e.u_lname, f.office, f.designation, g.c_name, b.timestamp, h.sstat_name
                    FROM document AS a
                    left join document_signatories AS b
                    ON (a.doc_id = b.doc_id)
                    left join users AS e
                    ON (e.id = b.u_id)
                    left join council_info AS f
                    ON (e.id = f.u_id)
                    left join council AS g
                    ON (f.c_id = g.c_id)
                    left join signatories_status AS h
                    ON (b.sstat_id = h.sstat_id)
                    WHERE g.c_name = 'Administrative Council'
                    order by a.doc_id
                    ");

                //automatic madisapprove ang pending document pag maabot na sa iyahang date of deadline
                date_default_timezone_set('Asia/Manila');
                $currDate = date('Y-m-d');
                $currTime = date('g:i A');

                $deadline = DB::select("
                    SELECT a.doc_id, a.doc_deadline
                    FROM document AS a
                    left join document_status_log AS b
                    ON (b.doc_id = a.doc_id)
                    WHERE b.docstatus_id = '1'
                    ");

                foreach ($deadline as $d)
                {
                    $todaydate = new DateTime($currDate);
                    $expirydate = new DateTime($d->doc_deadline);

                    if($expirydate <= $todaydate)
                    {
                        $todaytime = new DateTime($currTime);
                        $expirytime = new DateTime("12:00 PM"); //user-defined

                        if ($expirytime < $todaytime) 
                        { 
                            DB::table('document_status_log')
                            ->where('doc_id', $d->doc_id)
                            ->update(['docstatus_id' => 2]);
                        }
                    }
                }
                

                //dd($dataOnAdmin);

            return view('admin-dashboard', ['docs' => $dataOnDocs, 'acad' => $dataOnAcad, 'admin' => $dataOnAdmin]);
        }

        else if(Auth::user()->utype_id == 2)
        {
                
                $temp = Auth::user()->id;

                $dataOnUserDocs = DB::select("
                    SELECT a.doc_id, a.doc_title, a.doc_type, a.doc_desc, a.doc_file, a.doc_deadline, c.totalprogress, d.docstatus_name, b.u_dockeycode, e.u_fname, e.u_mname, e.u_lname, g.c_name, h.col_name
                    FROM document AS a 
                    left join document_signatories AS b 
                    ON (a.doc_id = b.doc_id) 
                    left join document_status_log AS c
                    ON (c.doc_id = a.doc_id)
                    left join document_status AS d
                    ON (c.docstatus_id = d.docstatus_id)
                    left join users AS e 
                    ON (e.id = b.u_id) 
                    left join council_info AS f 
                    ON (e.id = f.u_id) 
                    left join council AS g 
                    ON (f.c_id = g.c_id) 
                    left join college AS h 
                    ON (f.col_id = h.col_id) 
                    WHERE b.u_id = $temp AND b.sstat_id = '3' AND c.docstatus_id != 4
                    GROUP BY a.doc_id, a.doc_title, a.doc_type, a.doc_desc, a.doc_file, a.doc_deadline, c.totalprogress, d.docstatus_name, b.u_dockeycode, e.u_fname, e.u_mname, e.u_lname, g.c_name, h.col_name
                    ");

                 //dd($dataOnModals);

                 $dataOnAcad = DB::select("
                    SELECT a.doc_id, b.u_id, e.u_fname, e.u_mname, e.u_lname, g.c_name, h.col_name, i.docstatus_name
                    FROM document AS a
                    left join document_signatories AS b
                    ON (a.doc_id = b.doc_id)
                    left join users AS e
                    ON (e.id = b.u_id)
                    left join council_info AS f
                    ON (e.id = f.u_id)
                    left join council AS g
                    ON (f.c_id = g.c_id)
                    left join college AS h
                    ON (f.col_id = h.col_id)
                    left join document_status AS i
                    ON (b.sstat_id = i.docstatus_id)
                    WHERE g.c_name = 'Academic Council'
                    order by a.doc_id
                    ");

                //dd($dataOnAcad);

                $dataOnAdmin = DB::select("
                    SELECT a.doc_id, b.u_id, e.u_fname, e.u_mname, e.u_lname, f.office, f.designation, g.c_name
                    FROM document AS a
                    left join document_signatories AS b
                    ON (a.doc_id = b.doc_id)
                    left join users AS e
                    ON (e.id = b.u_id)
                    left join council_info AS f
                    ON (e.id = f.u_id)
                    left join council AS g
                    ON (f.c_id = g.c_id)
                    WHERE g.c_name = 'Administrative Council'
                    order by a.doc_id
                    ");

                //automatic madisapprove ang pending document pag maabot na sa iyahang date of deadline
                date_default_timezone_set('Asia/Manila');
                $currDate = date('Y-m-d');
                $currTime = date('g:i A');

                $deadline = DB::select("
                    SELECT a.doc_id, a.doc_deadline
                    FROM document AS a
                    left join document_status_log AS b
                    ON (b.doc_id = a.doc_id)
                    WHERE b.docstatus_id = '1'
                    ");

                foreach ($deadline as $d)
                {
                    $todaydate = new DateTime($currDate);
                    $expirydate = new DateTime($d->doc_deadline);

                    if($expirydate <= $todaydate)
                    {
                        $todaytime = new DateTime($currTime);
                        $expirytime = new DateTime("12:00 PM"); //user-defined

                        if ($expirytime < $todaytime) 
                        { 
                            DB::table('document_status_log')
                            ->where('doc_id', $d->doc_id)
                            ->update(['docstatus_id' => 2]);
                        }
                    }
                }

                $statID = DB::table('users')
                        ->where('id', $temp)
                        ->leftjoin('acceptance_log', 'acceptance_log.u_id', '=', 'users.id')
                        ->value('acceptance_log.astat_id');

                if ($statID == 3)   //di kasulod ang mga i.approve pa na mga users
                {
                    Session::flush();
                    Session::put('status','Your account registration is not yet verified by the administrator. Contact the USeP OSU for further details.');
                    return redirect('/');
                }


            return view('user-dashboard', ['data' => $dataOnUserDocs, 'keycodeData' => $dataOnUserDocs, 'admin' => $dataOnAdmin, 'acad' => $dataOnAcad, 'id' => $temp]);     
        }
    }
}
