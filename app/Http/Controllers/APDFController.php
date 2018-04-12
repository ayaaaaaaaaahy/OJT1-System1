<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use PDF;
use PDFMerger;
use Session;
use \setasign\Fpdi\Fpdi as FPDI;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class PDF_Rotate extends FPDI
{
    var $angle=0;

    function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->x;
        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }

    function _endpage()
    {
        if($this->angle!=0)
        {
            $this->angle=0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    function RotatedText($x,$y,$txt,$angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }

    function RotatedImage($file,$x,$y,$w,$h,$angle)
    {
        //Image rotated around its upper-left corner
        $this->Rotate($angle,$x,$y);
        $this->Image($file,$x,$y,$w,$h);
        $this->Rotate(0);
    }
}

class APDFController extends Controller
{
    
    public function print(Request $request){
    	if($request->input('print') != null){
            $id = $request->input('print');
            
            $data = DB::table('document_signatories')
            ->leftjoin('users', 'document_signatories.u_id', '=', 'users.id')
            ->leftjoin('council_info', 'users.id', '=', 'council_info.u_id')
	        ->leftjoin('council', 'council_info.c_id', '=', 'council.c_id')
	        ->leftjoin('college', 'council_info.col_id', '=', 'college.col_id')
	        ->select('users.u_signature', 'users.u_fname', 'users.u_mname', 'users.u_lname', 'council_info.office', 'council_info.designation', 'council.c_id', 'council.c_name', 'college.col_name', 'document_signatories.sstat_id')
            ->orderBy('council.c_name', 'desc')
            ->where('document_signatories.doc_id', $id)
	        ->get();

            $countAdmin = DB::table('document_signatories')
            ->where('doc_id', $id)
            ->leftjoin('users', 'document_signatories.u_id', '=', 'users.id')
            ->leftjoin('council_info', 'users.id', '=', 'council_info.u_id')
            ->leftjoin('council', 'council_info.c_id', '=', 'council.c_id')
            ->leftjoin('college', 'council_info.col_id', '=', 'college.col_id')
            ->select('users.u_signature', 'users.u_fname', 'users.u_mname', 'users.u_lname', 'council_info.office', 'council_info.designation', 'council.c_id', 'council.c_name', 'college.col_name')
            ->orderBy('council.c_name', 'desc')
            ->where('council.c_id', 2)
            ->count();

            $countAcad = DB::table('document_signatories')
            ->where('doc_id', $id)
            ->leftjoin('users', 'document_signatories.u_id', '=', 'users.id')
            ->leftjoin('council_info', 'users.id', '=', 'council_info.u_id')
            ->leftjoin('council', 'council_info.c_id', '=', 'council.c_id')
            ->leftjoin('college', 'council_info.col_id', '=', 'college.col_id')
            ->select('users.u_signature', 'users.u_fname', 'users.u_mname', 'users.u_lname', 'council_info.office', 'council_info.designation', 'council.c_id', 'council.c_name', 'college.col_name')
            ->orderBy('council.c_name', 'desc')
            ->where('council.c_id', 1)
            ->count();

            $temp = DB::table('document')       //document title
            ->where('doc_id', $id)
            ->value("document.doc_title"); 

            $withPrefix = str_pad($id, 5, '0', STR_PAD_LEFT);           //document id in a 5-digit format
            $pdfDate = date('dmY');
            $printDate = date('m/d/Y');

            $barcode = new BarcodeGenerator();              //generate barcode
            $barcode->setText('USeP OSU - '.$withPrefix);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setScale(5);
            $barcode->setThickness(25);
            $barcode->setFontSize(25);        
            $code = $barcode->generate();

            $image = base64_decode($code);          //iconvert ang generated barcode into png file
            $image_name = 'barcode_temp.png';
            $path = public_path() . "/temp/" . $image_name;
            file_put_contents($path, $image);

            $source = imagecreatefrompng($path);			//rotate barcode image to 90 degrees
		    $rotate = imagerotate($source, 90, 0);
		    imagepng($rotate,$path);

            Session::put('pageNum', 0);

            $customPaper = array(0,0,612,792);
	        PDF::loadView('pdf', ['data' => $data, 'info' => $data, 'admin' => $countAdmin, 'acad' => $countAcad, 'docu' => $temp, 'doc_id' => $id, "date" => $printDate])->setPaper($customPaper, 'portrait')->save('temp/temp.pdf');  //isave ang signatories pdf sa temp folder (public)

	        $original_file = DB::table('document')
            ->where('doc_id', $id)
            ->value('document.doc_file');    //existing doc file path (tung pdf na giupload gud haha)

            $pathFile = public_path($original_file);	//ichange ang syntax sa existing doc file path para mabasa sa PDFMerger
            $pathFile = str_replace('/',"\ ",$pathFile);
            $pathFile = str_replace(' ', '', $pathFile);

            $customPaper = array(279.4,215.9);      //i.set ang paper size sa 8.5 x 11 inches (converted to millimeters)
            $pdf = new PDF_Rotate();
            $pagecount = $pdf->setSourceFile($pathFile);        //total count sa pages sa existing pdf

            for ($x = 1; $x <= $pagecount; $x++)
            {
            	$tpl = $pdf->importPage($x);
	            $pdf->AddPage('p', $customPaper);
	            $pdf->useTemplate($tpl);
	            $pdf->SetFont('Helvetica'); 
	            $pdf->SetFontSize(10); 
			    $pdf->SetTextColor(0,0,0); 
			    $pdf->SetXY(15, 15); 
			    $pdf->RotatedText(8, 130, "Printed on: ".$printDate, 90);
	            $pdf->Image('temp/barcode_temp.png', 2, 135, 12, 70, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
	            $pdf->Image('img/footer.png', 12, 259, 191, 18, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
            }

            $pdf->Output("temp/sample.pdf", 'F');

			$pdf = new PDFMerger();		//diri na magmerge ang signatories ug edited na existing pdfs
            $pdf->addPDF("temp/sample.pdf", 'all');   
			$pdf->addPDF('temp/temp.pdf', 'all');

			$pdfDate = date('mdY');
			$newDocPathFile = $pdfDate .'-'. $temp .'-signatories'. '.pdf';			//pangalan sa newly generated pdf

			$pdf->merge('browser', $newDocPathFile);    //ipakita ang merged pdf and ready for download
        }    	
    }
    /*
    public function render($data){
    	$pdf = PDF::loadView('pdf.blade.php', $data);
		return $pdf->stream('pdf.pdf');
		dd($data);
    }
    */   
}
