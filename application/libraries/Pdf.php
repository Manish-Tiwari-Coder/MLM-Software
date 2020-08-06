<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('DOMPDF_ENABLE_AUTOLOAD', FALSE);
use Dompdf\Dompdf;

class Pdf
{

    public function generate($html, $filename = '', $stream = TRUE, $paper = 'A4', $orientation = "portrait", $attachment = 1)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename . ".pdf", array("Attachment" => $attachment));
        }
        else {
            return $dompdf->output();
        }
    }
}