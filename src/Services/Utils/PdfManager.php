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
                'orientation' => 'portrait',
                'enable-javascript' => true,
                'javascript-delay' => 1000,
                'no-stop-slow-scripts' => true,
                'no-background' => false,
                'lowquality' => false,
                'page-width' => '8cm',
                'page-height' => '12.40cm',
                'margin-left'=>0,
                'margin-right'=>0,
                'margin-top'=>0,
                'margin-bottom'=>0,
                'encoding' => 'utf-8',
                'images' => true,
                'cookie' => array(),
                'dpi' => 300,
                'enable-external-links' => true,
                'enable-internal-links' => true,
                )),
            $filename 
        );
    }
}