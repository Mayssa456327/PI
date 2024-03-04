<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomenotloginController extends AbstractController
{
    #[Route('/homenotlogin', name: 'app_homenotlogin')]
    public function homenotlogin(): Response
    {
        return $this->render('homenotlogin/index.html.twig');
    }
}
