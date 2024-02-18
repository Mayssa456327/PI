<?php

// Exemple avec le contrôleur AgriculteurController

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Request;

use Symfony\Component\HttpClient\HttpClient;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegistrationFormType;

use App\Form\UserType;
use App\Repository\UserRepository;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;







class MedecinController extends AbstractController
{
    #[Route('/medecin/dashboard', name: 'medecin_dashboard')]
    public function dashboard(): Response
    {
        $user = $this->getUser();

        return $this->render('medecin/dashboard.html.twig', [
            'user' => $user,
            // Ajoutez d'autres informations spécifiques à l'agriculteur si nécessaire
        ]);
    }


    #[Route('/medecin/profile', name: 'medecin_profile')]
    public function showProfil(): Response
    {
        // Récupérez les informations du médecin, par exemple à partir de la session
        $medecin = $this->getUser();

        // Passez les informations du médecin à la vue
        return $this->render('medecin/profil.html.twig', [
            'medecin' => $medecin,
        ]);
    }
}
