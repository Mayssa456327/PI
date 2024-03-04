<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DSController extends AbstractController
{
    #[Route('/ds', name: 'app_d_s')]
    public function index(): Response
    {
        return $this->render('ds/index.html.twig', [
            'controller_name' => 'DSController',
        ]);
    }
}
