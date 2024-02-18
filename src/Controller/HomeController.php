<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'homePage')]
    public function index(): Response
    {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/about', name: 'aboutPage')]
    public function about(): Response
    {
        return $this->render('project/about.html.twig');
    }

    #[Route('/doctor', name: 'doctorPage')]
    public function doctor(): Response
    {
        return $this->render('project/doctor.html.twig');
    }
    #[Route('/departements', name: 'departementsPage')]
    public function departements(): Response
    {
        return $this->render('project/departements.html.twig');
    }
    #[Route('/blog', name: 'blogPage')]
    public function blog(): Response
    {
        return $this->render('project/blog.html.twig');
    }
    #[Route('/contact', name: 'contactPage')]
    public function contact(): Response
    {
        return $this->render('project/contact.html.twig');
    }
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, SessionInterface $session): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Store data in the session (example: user ID)
        if ($this->getUser()) {
            $userId = $this->getUser()->getId();
            $session->set('user_id', $userId);

            // Redirect user based on role
            $targetRoute = $this->getTargetRouteForRole($this->getUser()->getRoles());
            return $this->redirectToRoute($targetRoute);
        }

        return $this->render('project/Sign_in.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    #[Route('/signUp', name: 'signUpPage')]
    public function signUp(): Response
    {
        return $this->render('project/Sign_up.html.twig');
    }
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
