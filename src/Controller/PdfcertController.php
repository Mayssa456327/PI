<?php

namespace App\Controller;

use App\Entity\Cert;
use App\Service\pdfService;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class PdfcertController extends AbstractController
{

    private EntityManagerInterface $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/pdf/{id}', name: 'attachment.pdf')]
    public function generatePdfCert( $id ,Cert $cert = null, PdfService $pdf): Response
    {

        $cert = $this->entityManager->getRepository(Cert::class)->find($id);
        
        $html = $this->renderView('cert/pdf/showPdf.html.twig', ['cert' => $cert]);
        $pdfContent = $pdf->generatePdfFile($html); // Assume that the method returns the content of the PDF

        $response = new Response($pdfContent);
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            'certificate.pdf'
        );
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;


    }

}
