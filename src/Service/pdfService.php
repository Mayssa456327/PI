<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use phpDocumentor\Reflection\Types\False_;

class pdfService
{
    private  $domPdf;

    public function __construct() {
        $this->domPdf = new DomPdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->stream("details.pdf", [
            'Attachment' => false
        ]);
    }

    public function generateBinaryPDF($html) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->output();
    }

    public function generatePdfFile(string $html)
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        return $this->domPdf->output();
    }


}