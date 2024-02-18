<?php

namespace App\Controller;

// src/Controller/SecurityController.php

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SecurityController extends AbstractController
{

    #[Route(path: '/ban', name: 'ban_page')]
    public function banPage(): Response
    {
        return $this->render('ban.html.twig');
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): void
    {
        // Clear specific data from the session
        $session->remove('user_id');

        // Clear all session data (invalidate the session)
        $session->clear();

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * Determine the target route based on user roles.
     *
     * @param array $roles
     * @return string
     */
    private function getTargetRouteForRole(array $roles): string
    {
        foreach ($roles as $role) {
            if ($role === 'ADMIN') {
                return 'app_admin1_index';
            } elseif ($role === 'MEDECIN') {
                return 'medecin_dashboard';
            } elseif ($role === 'PATIENT') {
                return 'patient_dashboard';
            }
        }

        // Si aucun rôle ne correspond, rediriger vers une route par défaut
        return 'app_login';
    }

}
