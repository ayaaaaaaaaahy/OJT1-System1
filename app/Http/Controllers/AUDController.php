<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use Validator;
use Redirect;
use Session;
use Mail;

class AUDController extends Controller
{
    public function index()
    {
        $data = DB::select("
                    SELECT a.id, a.u_fname, a.u_mname, a.u_lname, a.email, d.office, d.designation, e.c_name, f.col_name
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
                    WHERE c.astat_name = 'Accepted'
                    ORDER BY a.u_lname
        ");

        $temp = Auth::user()->id;
        
        return view('admin-uploadoption', ['data' => $data, 'info' => $data, 'user_id' => $temp]);
    }

    public function upload(Request $request)
    {
        $name = Input::get('doc_title');
        $type = Input::get('doc_type');
        $deadline = Input::get('doc_deadline');
        $description = Input::get('doc_desc');
        //PDF Upload        
        //Gets the Input
        $file = $request->file('doc_file');

        //Validation for both the input in which both of them are required
        $rules = array(
            'doc_title' => 'required',
            'doc_type' => 'required',
            'doc_deadline' => 'required',
            'doc_desc' => 'required',
            'doc_file' => 'required|max:5120|mimes:pdf');
        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){
            //Redirect User back with error messages
            $messages = $validator->messages();
            //Pass session failure
            $failure = array(
                'failure' => 'Failed Upload!'
            );
            //Send user back to page with input data and errors
            return Redirect::back()->withInput()->withErrors($messages)->with($failure);
        }
        else if($validator->passes()){      
                //Check if file is valid
                if($request->file('doc_file')->isValid()){
                    //Path to where pdf are stored. Which is *Project Folder*
                    $destinationPath = '/PDF/';             
                    //Get File selected
                    $filepdf = $request->file('doc_file');
                    $pdfname = $request->get('file_title');
                    $filename = date('mdy') .'-' .  $pdfname . $filepdf->getClientOriginalName();
                    //Move file somewhere
                    $file->move(public_path().$destinationPath,$filename);  
                    //Use for inserting pdf to database
                    $pdfpath = "$destinationPath$filename";
                    //Notification if successful
                    $notification = array(
                        'message' => 'File Uploaded Succesfully!',
                        'alert-type' => 'success');

                    $data = DB::table('document')
                        ->insert(['doc_title' =>$name, 'doc_type' =>$type, 'doc_file' => $pdfpath, 'doc_deadline' => $deadline, 'doc_desc' => $description]);    
        }
        else{
                //Notification if failed
                $notification = array(
                    'message' => 'File Not Valid!',
                    'alert-type' => 'error');
                $failure = array(
                    'failure' => 'Failed Upload!');
                return Redirect::to('/')->with($failure);
            }       
        //End of PDF Upload

        $data = DB::table('users')->get();
        $latestDoc = DB::table('document')->latest('doc_id')->first();
        $docuNum = $latestDoc->doc_id;         //ID of the most recent document uploaded
        $docuName = $latestDoc->doc_title;      //name of the most recent document uploaded

        Session::put('docuNum', $docuNum);  //sessions are used so that it can be read in the Mail "dimension"

        $selectedEmails = array();
        $users = array();
        $passcode = "";
        $index = 0;

        foreach($data as $key)
        {
            $index = $key->id;

            if ($request->has($index))      //know if the checkbox (per email) is checked or not
            {
                $anEmail = $key->email;
                $selectedEmails[] = $anEmail;   //insert selected email recipient on an array
                $users[] = $index;              //insert also the account ID for reference
            }
            
        }

        $counter = 0;
        Session::put('count', $counter);

        $emailSize = sizeOf($selectedEmails);

        for ($x = 0; $x < $emailSize; $x++)
        {
            //**************** code block for creating 10-character long random password ***************
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array();
            $alphaLength = strlen($alphabet) - 1; 
                    
            for ($i = 0; $i < 10; $i++) 
            {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }

            $passcode = implode($pass); //the created password for  a specific email recipient
           
                Mail::send('emails.mail', ['title' => $docuName, 'passcode' => $passcode], function ($message) use ($selectedEmails, $users, $passcode)
                {
                    $temp = Session::get('count');
                    $message->from('universitysecretary.office@gmail.com', "USeP Records Office");
                    $message->to($selectedEmails[$temp]);
                    $message->subject("Document Passcode"); 

                    $num = Session::get('docuNum');
                    DB::table('document_signatories')->insert(['doc_id' => $num, 'u_id' => $users[$temp], 'sstat_id' => 3, 'u_dockeycode' => $passcode]);  //insert the generated details in the database immediately
                    $temp++;
                    Session::put('count', $temp);
                });
        }

            $emailCount = count($selectedEmails);
            DB::table('document_status_log')->insert(['doc_id' => Session::get('docuNum'), 'docstatus_id' => 1, 'totalusers' => $emailCount, 'totalprogress' => 0,  'totalaccept' => 0, 'totalreject' => 0]);

            Session::put('status','Document Succesfully Uploaded.');
            return Redirect::to('/upload');
    }

    

}

}