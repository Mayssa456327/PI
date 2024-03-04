<?php

namespace App\Controller;

use App\Entity\DemAn;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemAnController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    #[Route('/deman', name: 'deman')]
    public function deman(): Response
    {
        {
            $demans = $this->entityManager->getRepository(DemAn::class)->findAll();




            return $this->render('dem_an/index.html.twig', [
                'demans' => $demans,

            ]);
        }
    }
}
