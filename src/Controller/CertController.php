<?php

namespace App\Controller;

use App\Entity\Cert;
use App\Repository\CertRepository;
use App\Service\pdfService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;


class CertController extends AbstractController
{
    private EntityManagerInterface $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function showCertificate(Cert $cert): Response
    {
        return $this->render('cert/show.html.twig', [
            'cert' => $cert,
        ]);
    }
    #[Route('/cert', name: 'cert')]
    public function cert(): Response
    {
        {
            $certs = $this->entityManager->getRepository(Cert::class)->findAll();

            return $this->render('cert/index.html.twig', [
                'certs' => $certs,

            ]);
        }
    }



}