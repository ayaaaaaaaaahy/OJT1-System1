<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class UHController extends Controller
{
    public function documenthistory()
    {
    	$temp = Auth::user()->id;
    	$myHistory = DB::select("
                    SELECT b.doc_title, b.doc_type, b.doc_desc, d.sstat_name, c.timestamp
                    FROM document AS b
                    left join document_signatories AS c
                    ON (c.doc_id = b.doc_id)
                    left join signatories_status AS d
                    ON (c.sstat_id = d.sstat_id)
                    left join users AS e
                    ON (c.u_id = e.id)
                    where e.id = $temp
                    order by c.timestamp desc
                ");

        return view('user-documenthistory', ['docs' => $myHistory]);
    }

}
