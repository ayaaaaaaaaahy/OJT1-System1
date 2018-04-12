<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use Mail;

class AAUController extends Controller
{
    public function index()
    {
        $data = DB::select("
                    SELECT a.id, a.u_fname, a.u_mname, a.u_lname, a.email, c.astat_name, d.office, d.designation, e.c_name, f.col_name, g.ugen_name
                    FROM users AS a
                    left join acceptance_log AS b
                    ON (a.id = b.u_id)
                    left join acceptance_status AS c
                    ON (b.astat_id = c.astat_id)
                    left join council_info AS d
                    ON (a.id = d.u_id)
                    left join council AS e
                    ON (d.c_id = e.c_id)
                    left join college AS f
                    ON (d.col_id = f.col_id)
                    left join user_gender AS g
                    ON (a.ugen_id = g.ugen_id)
                    WHERE c.astat_name = 'Pending'
        ");

        return view('admin-acceptuser', ['data' => $data]);
    }

    public function accept(Request $request)
    {
        if($request->input('ACCEPT') != null)
        {
            $id = $request->input('ACCEPT');

            DB::table('acceptance_log')
            ->where('u_id', $id)
            ->update(['astat_id' => 1]);

	        $getEmail = DB::select("
	                    SELECT a.email, a.u_lname, b.ugen_name
	                    FROM users AS a
	                    left join user_gender AS b
	                    ON (a.ugen_id = b.ugen_id)
	                    WHERE a.id = $id
	        ");

	        foreach ($getEmail as $data) 
	        {
	            $u_gender = $data->ugen_name;
	            $lastname = $data->u_lname;
	            $stat = "ACCEPT";

	            Mail::send('emails.accountNotif', ['stat' => $stat, 'gender' => $u_gender, 'lastname' => $lastname], function ($message) use ($data)
	            {
	                    $message->from('universitysecretary.office@gmail.com', "USeP Records Office");
	                    $message->to($data->email);
	                    $message->subject("Account Registration - Notification"); 
	            });
	        }
        }

        if($request->input('DECLINE') != null)
        {
            $id = $request->input('DECLINE');

            $getEmail = DB::select("
	                    SELECT a.email, a.u_lname, b.ugen_name
	                    FROM users AS a
	                    left join user_gender AS b
	                    ON (a.ugen_id = b.ugen_id)
	                    WHERE a.id = $id
	        ");

	        foreach ($getEmail as $data) 
	        {
	            $u_gender = $data->ugen_name;
	            $lastname = $data->u_lname;
	            $stat = "DECLINE";

	            Mail::send('emails.accountNotif', ['stat' => $stat, 'gender' => $u_gender, 'lastname' => $lastname], function ($message) use ($data)
	            {
	                    $message->from('universitysecretary.office@gmail.com', "USeP Records Office");
	                    $message->to($data->email);
	                    $message->subject("Account Registration - Notification"); 
	            });
	        }

            $imgpath = DB::table('users')->where('id', $id)->value('users.u_signature'); 

            $pathFile = public_path($imgpath);    //ichange ang syntax sa existing signature image path para mabasa sa unlink()
            $pathFile = str_replace('/',"\ ",$pathFile);
            $pathFile = str_replace(' ', '', $pathFile);

            if (file_exists($pathFile))
            {
                unlink($pathFile);          //para madelete pud ug apil ang existing signature image kay wala na siyay pulos eh
            }

            DB::table('document_signatories')->where('u_id', $id)->delete();
            DB::table('acceptance_log')->where('u_id', $id)->delete();
            DB::table('council_info')->where('u_id', $id)->delete();
            DB::table('users')->where('id', $id)->delete();

            $signaData = DB::table('document_signatories')->get();

            if ($signaData->isEmpty())    //kay di man matruncate ang users table kay naa didto ang superadmin haha
            {
                DB::statement("TRUNCATE TABLE document_signatories;");
            }
            /*
            //reorder ang tables na dependent sa users id para han.ay tan.awon
            DB::statement("SET @count = 0;");
            DB::statement("UPDATE acceptance_log SET log_id = @count:= @count + 1;");
            $max = DB::table('acceptance_log')->max('log_id') + 1; 
            DB::statement("ALTER TABLE acceptance_log AUTO_INCREMENT =  $max");

            DB::statement("SET @count = 0;");
            DB::statement("UPDATE council_info SET ci_id = @count:= @count + 1;");
            $max = DB::table('council_info')->max('ci_id') + 1; 
            DB::statement("ALTER TABLE council_info AUTO_INCREMENT =  $max");
            
            DB::statement("SET @count = 0;");
            DB::statement("UPDATE users SET id = @count:= @count + 1;");
            $max = DB::table('users')->max('id') + 1; 
            DB::statement("ALTER TABLE users AUTO_INCREMENT =  $max");
            
            DB::statement("SET @count = 0;");
            DB::statement("UPDATE document_signatories SET docsign_id = @count:= @count + 1;");
            $max = DB::table('document_signatories')->max('docsign_id') + 1; 
            DB::statement("ALTER TABLE document_signatories AUTO_INCREMENT =  $max");
            */
        }


        return $this->index();
    }

    public function userinfoajax()
    {
    	//diri ibutang ang function sa pagkuha ug information sa admin
    	//kani na part kay ajax ni kabalo ko na kabalo ka mu ajax.
    }
    
}
