<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
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
    #[Route('/signIn', name: 'signInPage')]
    public function signIn(): Response
    {
        return $this->render('project/Sign_in.html.twig');
    }
    #[Route('/signUp', name: 'signUpPage')]
    public function signUp(): Response
    {
        return $this->render('project/Sign_up.html.twig');
    }
}
