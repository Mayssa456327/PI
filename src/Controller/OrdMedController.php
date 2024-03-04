<?php

namespace App\Controller;

use App\Entity\OrdMed;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OrdMedController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    #[Route('/ordmed', name: 'ordmed')]
    public function ordmed(): Response
    {
        {
            $ordmeds = $this->entityManager->getRepository(OrdMed::class)->findAll();




            return $this->render('ord_med/index.html.twig', [
                'ordmeds' => $ordmeds,

            ]);
    }
}

}
