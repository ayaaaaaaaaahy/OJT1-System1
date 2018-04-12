<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    public function showRegistrationForm()
    {
        if(Auth::guest()){
            return view('auth.register');
        }else{
            return redirect('/');
        }
    }

    public function register()
    {
        $rules = [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'fname' => 'regex:/^[a-zA-Z ]+$/',
            'mname' => 'regex:/^[a-zA-Z ]+$/',
            'lname' => 'regex:/^[a-zA-Z ]+$/',
            'radio-stacked1' => 'required|in:1,2', 
            'radio-stacked3' => 'required|in:1,2',
            'myfile' => 'required | image | max:8388608'
        ];

        $input = Input::only(
            'email',
            'password',
            'password_confirmation',
            'fname',
            'mname',
            'lname',
            'radio-stacked1',
            'radio-stacked3',
            'myfile'
        );

        $validator = Validator::make($input, $rules);

        if($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }else{

            $destinationPath = '/uploads/';
            $filename = uniqid() .'-' . $input['myfile']->getClientOriginalName();
            $input['myfile']->move(public_path().$destinationPath,$filename);  
            $signatureimg = "$destinationPath$filename";

            $data = DB::table('users')
                ->insert([
                    'u_fname' => $input['fname'],
                    'u_mname' => $input['mname'],
                    'u_lname' => $input['lname'], 
                    'email' => $input['email'], 
                    'password' => Hash::make($input['password']), 
                    'ugen_id' => $input['radio-stacked1'],
                    'u_signature' => $signatureimg,
                    'u_profpic' => null,
                    'utype_id' => 2]
                );


            $council = Input::get('radio-stacked3');
            $userid = DB::table('users')->select('id')->where('email', $input['email'])->first();

            if($council == 1){
                $college = Input::get('college');
                if($college != null){  
                    $data = DB::table('council_info')
                    ->insert([
                        'u_id' => $userid->id,
                        'c_id' => $input['radio-stacked3'],
                        'col_id' => $college 
                    ]);
                }else{
                    return Redirect::back()->withInput()->withErrors(['msg', 'Please select a required college data']);
                }
            }else if($council == 2){
                $office = Input::get('office');
                $designation = Input::get('designation');
                if($office != null && $designation != null ){  
                     $data = DB::table('council_info')
                    ->insert([
                        'u_id' => $userid->id,
                        'c_id' => $input['radio-stacked3'],
                        'office' => $office,
                        'designation' => $designation
                    ]);
                }else{
                    return Redirect::back()->withInput()->withErrors(['msg', 'Please provide the required office and designation data']);
                }
            }

            $data = DB::table('acceptance_log')
                    ->insert([
                        'u_id' => $userid->id,
                        'astat_id' => 3 
                    ]);

           Session::put('success_register','Account registration is complete. You will be notified via e-mail once your account is verified by USeP OSU.');
           return redirect('/');
        }
    }

}
