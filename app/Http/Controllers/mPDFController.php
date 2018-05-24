<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use niklasravnsborg\LaravelPdf\Facades\Pdf;

class mPDFController extends Controller
{
    //use PDF;

    function generate_pdf() {
        $data = [
            'foo' => 'bar'
        ];
        $pdf = PDF::loadView('admin.pdf.pdf', $data);
        return $pdf->stream('admin.pdf.pdf');
    }
}


