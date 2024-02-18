<?php

// Exemple avec le contrôleur AgriculteurController

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    #[Route('/patient/dashboard', name: 'patient_dashboard')]
    public function dashboard(): Response
    {
        $user = $this->getUser();

        return $this->render('patient/dashboard.html.twig', [
            'user' => $user,
            // Ajoutez d'autres informations spécifiques à l'agriculteur si nécessaire
        ]);
    }
    #[Route('/patient/profile', name: 'patient_profile')]
    public function showProfil(): Response
    {
        // Récupérez les informations du médecin, par exemple à partir de la session
        $patient = $this->getUser();

        // Passez les informations du médecin à la vue
        return $this->render('patient/profil.html.twig', [
            'patient' => $patient,
        ]);
    }
}
