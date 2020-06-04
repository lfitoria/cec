<?php

namespace App\Services\Utils;

use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

class PdfManager{

    private $pdf;
    
    public function __construct(Pdf $pdf) {
        $this->pdf = $pdf;
    }

    public function generatePdf($html,$id,$year) {

        //definir titulo
        $filename = "Proyecto-CEC-".$id."-".$year.".pdf";

        return new PdfResponse(
            $this->pdf->getOutputFromHtml($html,array(
                
                
                )),
            $filename 
        );
    }
}