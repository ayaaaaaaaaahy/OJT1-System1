<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class AHController extends Controller
{
    public function documenthistory()
    {
    	$dataOnDocs = DB::select("
            		SELECT b.doc_title, b.doc_type, d.sstat_name, e.u_fname, e.u_mname, e.u_lname, c.timestamp
                    FROM document AS b
                    left join document_signatories AS c
                    ON (c.doc_id = b.doc_id)
                    left join signatories_status AS d
                    ON (c.sstat_id = d.sstat_id)
                    left join users AS e
                    ON (c.u_id = e.id)
                    order by c.timestamp desc
        ");


        return view('admin-documenthistory',['docs' => $dataOnDocs]);
    }

    public function userhistory()
    {
    	$dataOnDocs = DB::select("
            		SELECT a.u_fname, a.u_mname, a.u_lname, b.c_id, c.c_name, b.office, b.designation, d.col_name, e.timestamp, f.astat_name
                    FROM users AS a
                    left join council_info AS b
                    ON (a.id = b.u_id)
                    left join council AS c
                    ON (b.c_id = c.c_id)
                    left join college AS d
                    ON (b.col_id = d.col_id)
                    left join acceptance_log AS e
                    ON (a.id = e.u_id)
                    left join acceptance_status AS f
                    ON (e.astat_id = f.astat_id)
                    order by e.timestamp desc
        ");


        return view('admin-userhistory',['docs' => $dataOnDocs]);
    }
}
