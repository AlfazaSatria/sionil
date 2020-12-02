<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;

class PdfController extends Controller
{
    public function PDFTahfiz()
    {
        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml(
        '
        
        '

        );
        $dompdf->render();


        $dompdf->stream("RaportTahfiz_SMPMumtaza");
    }
}
