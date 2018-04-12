<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use Session;

class UController extends Controller
{
    
    public function acceptdoc(Request $request)
    {
        $docu_id = $request->input('doc');
        $key = $request->input('keycode');
        $truekey = DB::table('document_signatories')->where('u_id', Auth::user()->id)->where('doc_id', $docu_id)->value('u_dockeycode');
        //dd($key, $truekey, $docu_id);
        if($key == $truekey){
            //dd('true');
            if($request->input('ACCEPT') != null){
                $id = $request->input('ACCEPT');
                
                DB::table('document_signatories')
                ->where('doc_id', $id)
                ->where('u_id', Auth::user()->id )
                ->update(['sstat_id' => 1]);

                DB::table('document_status_log')
                ->where('doc_id', $id)
                ->increment('totalaccept');

                $totalusers = DB::table('document_status_log')->where('doc_id', $id)->value('totalusers');
                $totalaccept = DB::table('document_status_log')->where('doc_id', $id)->value('totalaccept');
                $totalreject = DB::table('document_status_log')->where('doc_id', $id)->value('totalreject');
                $totalprogress = ((($totalaccept+$totalreject)/$totalusers)*100);
                
                DB::table('document_status_log')
                ->where('doc_id', $id)
                ->update(['totalprogress' => $totalprogress]);

                if (($totalaccept/$totalusers) >= 0.5)
                {
                        DB::table('document_status_log')
                        ->where('doc_id', $id)
                        ->update(['docstatus_id' => 3]);
                }

                if ($totalprogress == 100)          //dri madecide ang overall status sa document if tanan na ang nakasign
                {
                    if($totalaccept >= $totalreject)
                    {
                        DB::table('document_status_log')
                        ->where('doc_id', $id)
                        ->update(['docstatus_id' => 3]);
                    }
                    else
                    {
                        DB::table('document_status_log')
                        ->where('doc_id', $id)
                        ->update(['docstatus_id' => 2]);
                    }
                }

            }
            if($request->input('DECLINE') != null){
                $id = $request->input('DECLINE');
                
                DB::table('document_signatories')
                ->where('doc_id', $id)
                ->where('u_id', Auth::user()->id)
                ->update(['sstat_id' => 2]);

                DB::table('document_status_log')
                ->where('doc_id', $id)
                ->increment('totalreject');

                $totalusers = DB::table('document_status_log')->where('doc_id', $id)->value('totalusers');
                $totalaccept = DB::table('document_status_log')->where('doc_id', $id)->value('totalaccept');
                $totalreject = DB::table('document_status_log')->where('doc_id', $id)->value('totalreject');
                $totalprogress = ((($totalaccept+$totalreject)/$totalusers)*100);
                
                DB::table('document_status_log')
                ->where('doc_id', $id)
                ->update(['totalprogress' => $totalprogress]);

                if (($totalreject/$totalusers) >= 0.5)
                {
                        DB::table('document_status_log')
                        ->where('doc_id', $id)
                        ->update(['docstatus_id' => 2]);
                }

                if ($totalprogress == 100)
                {
                    if($totalaccept >= $totalreject)
                    {
                        DB::table('document_status_log')
                        ->where('doc_id', $id)
                        ->update(['docstatus_id' => 3]);
                    }
                    else
                    {
                        DB::table('document_status_log')
                        ->where('doc_id', $id)
                        ->update(['docstatus_id' => 2]);
                    }
                }
            }
        }   	
        else{
           //dd('false');
        }

        return redirect()->route('home');
    }
    
}
