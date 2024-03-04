<?php

namespace App\Controller;





use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\Routing\Attribute\Route;


class BackadminController extends AbstractController
{
    #[Route('/backadmin', name: 'app_backadmin')]
    public function backadmin(): Response
    {
        return $this->render('backadmin/baseBack.html.twig');
    }
}