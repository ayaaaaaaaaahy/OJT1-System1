<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DateTime;
use Redirect;
use Auth;
use DB;
use Mail;

class ATController extends Controller
{
    public function index()
    {
                $dataOnDocs = DB::select("
                    SELECT a.doc_id, a.doc_title, a.doc_type, a.doc_desc, a.doc_file, a.doc_deadline, c.totalprogress, d.docstatus_name
                    FROM document AS a
                    left join document_status_log AS c
                    ON (c.doc_id = a.doc_id)
                    left join document_status AS d
                    ON (c.docstatus_id = d.docstatus_id)
                    WHERE c.docstatus_id = 4
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
                

                //dd($dataOnAdmin);

            return view('admin-trash', ['docs' => $dataOnDocs, 'acad' => $dataOnAcad, 'admin' => $dataOnAdmin]);
    }

    public function trashDocu(Request $request)
    {
        $docu = Input::get('docID');
        DB::table('document_status_log')->where('doc_id', $docu)->update(['docstatus_id' => 4]);

        $getEmails = DB::select("
                    SELECT a.email, a.u_lname, c.doc_title, d.ugen_name
                    FROM users AS a
                    left join document_signatories AS b
                    ON (a.id = b.u_id)
                    left join document AS c
                    ON (b.doc_id = c.doc_id)
                    left join user_gender AS d
                    ON (a.ugen_id = d.ugen_id)
                    WHERE b.doc_id = $docu
        ");

        foreach ($getEmails as $data) 
        {
            $docTitle = $data->doc_title;
            $u_gender = $data->ugen_name;
            $lastname = $data->u_lname;

            Mail::send('emails.trashNotif', ['title' => $docTitle, 'gender' => $u_gender, 'lastname' => $lastname], function ($message) use ($data)
            {
                    $message->from('universitysecretary.office@gmail.com', "USeP Records Office");
                    $message->to($data->email);
                    $message->subject("Document Removal - Notification"); 
            });
        }


        return Redirect::to('/home');
    }

    public function recoverDocu(Request $request)
    {
        $id = Input::get('docID');

        $totalusers = DB::table('document_status_log')->where('doc_id', $id)->value('totalusers');
        $totalaccept = DB::table('document_status_log')->where('doc_id', $id)->value('totalaccept');
        $totalreject = DB::table('document_status_log')->where('doc_id', $id)->value('totalreject');
        $totalprogress = ((($totalaccept+$totalreject)/$totalusers)*100);

        if (($totalaccept/$totalusers) >= 0.5)
        {
            DB::table('document_status_log')
            ->where('doc_id', $id)
            ->update(['docstatus_id' => 3]);
        }
        else if (($totalreject/$totalusers) > 0.5)
        {
            DB::table('document_status_log')
            ->where('doc_id', $id)
            ->update(['docstatus_id' => 2]);    
        }
        else
        {
            DB::table('document_status_log')
            ->where('doc_id', $id)
            ->update(['docstatus_id' => 1]);
        }   

        $getEmails = DB::select("
                    SELECT a.email, a.u_lname, c.doc_title, d.ugen_name
                    FROM users AS a
                    left join document_signatories AS b
                    ON (a.id = b.u_id)
                    left join document AS c
                    ON (b.doc_id = c.doc_id)
                    left join user_gender AS d
                    ON (a.ugen_id = d.ugen_id)
                    WHERE b.doc_id = $id
        ");

        foreach ($getEmails as $data) 
        {
            $docTitle = $data->doc_title;
            $u_gender = $data->ugen_name;
            $lastname = $data->u_lname;

            Mail::send('emails.recoverNotif', ['title' => $docTitle, 'gender' => $u_gender, 'lastname' => $lastname], function ($message) use ($data)
            {
                    $message->from('universitysecretary.office@gmail.com', "USeP Records Office");
                    $message->to($data->email);
                    $message->subject("Document Recovery - Notification"); 
            });
        }

        return $this->index();
    }

    public function deleteDocu(Request $request)
    {
        $docu = Input::get('docID');

        $getEmails = DB::select("
                    SELECT a.email, a.u_lname, c.doc_title, d.ugen_name
                    FROM users AS a
                    left join document_signatories AS b
                    ON (a.id = b.u_id)
                    left join document AS c
                    ON (b.doc_id = c.doc_id)
                    left join user_gender AS d
                    ON (a.ugen_id = d.ugen_id)
                    WHERE b.doc_id = $docu
        ");

        foreach ($getEmails as $data) 
        {
            $docTitle = $data->doc_title;
            $u_gender = $data->ugen_name;
            $lastname = $data->u_lname;

            Mail::send('emails.deleteNotif', ['title' => $docTitle, 'gender' => $u_gender, 'lastname' => $lastname], function ($message) use ($data)
            {
                    $message->from('universitysecretary.office@gmail.com', "USeP Records Office");
                    $message->to($data->email);
                    $message->subject("Document Deletion - Notification"); 
            });
        }

        $docpath = DB::table('document')->where('doc_id', $docu)->value('document.doc_file'); 

        $pathFile = public_path($docpath);    //ichange ang syntax sa existing doc file path para mabasa sa unlink()
        $pathFile = str_replace('/',"\ ",$pathFile);
        $pathFile = str_replace(' ', '', $pathFile);

        if (file_exists($pathFile))
        {
            unlink($pathFile);          //para madelete pud ug apil ang existing document kay wala na siyay pulos eh
        }

        DB::table('document_signatories')->where('doc_id', $docu)->delete();
        DB::table('document_status_log')->where('doc_id', $docu)->delete();
        DB::table('document')->where('doc_id', $docu)->delete();

        $documentData = DB::table('document')->get();

        //truncate para marearrange ang documents ug marestart ang auto-increment (orderliness and formality haha)
        if ($documentData->isEmpty())
        {
            DB::statement("TRUNCATE TABLE document;");
            DB::statement("TRUNCATE TABLE document_status_log;");
            DB::statement("TRUNCATE TABLE document_signatories;");
        }
        else                    //reorder ang tables na dependent sa document id para han.ay tan.awon
        {
                /*
                DB::statement("SET @count = 0;");
                DB::statement("UPDATE document SET doc_id = @count:= @count + 1;");
                $max = DB::table('document')->max('doc_id') + 1; 
                DB::statement("ALTER TABLE document AUTO_INCREMENT =  $max");
                
                DB::statement("SET @count = 0;");
                DB::statement("UPDATE document_status_log SET doclog_id = @count:= @count + 1;");
                $max = DB::table('document_status_log')->max('doclog_id') + 1; 
                DB::statement("ALTER TABLE document_status_log AUTO_INCREMENT =  $max");

                DB::statement("SET @count = 0;");
                DB::statement("UPDATE document_signatories SET docsign_id = @count:= @count + 1;");
                $max = DB::table('document_signatories')->max('docsign_id') + 1; 
                DB::statement("ALTER TABLE document_signatories AUTO_INCREMENT =  $max");
                */

        }
        
        return $this->index();
    }

    public function editajax()
    {
    	//diri ibutang ang function sa edit sa admin
    	//kani na part kay ajax ni kabalo ko na kabalo ka mu ajax.
    }

    public function deleteajax()
    {
    	//diri ibutang ang function sa delete sa admin 
    	//kani na part kay ajax ni kabalo ko na kabalo ka mu ajax.
    }
}
