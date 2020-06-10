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
            $this->pdf->generateFromHtml($html,$filename,array(
                'page-width' => '21.59cm',
                'page-height' => '27.94cm',
                'margin-left'=>'1.9cm',
                'margin-right'=>'1.9cm',
                'margin-top'=>'1.9cm',
                'margin-bottom'=>'1.9cm',
                'encoding' => 'utf-8',
                'images' => false,
                'enable-external-links' => true,
                'enable-internal-links' => true,
                'lowquality' => true,
                'dpi' => 80,
                'image-quality' => 80,
                'no-outline' => true
                )),
            $filename 
        );
    }
}