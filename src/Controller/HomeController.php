<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPassType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
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

    /**
     * @throws RandomException
     */
    #[Route('/oubli_pass', name: 'forgotten_password')]
    public function forgotPassword(Request $request, \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Find user by email
            $email = $form->get('email')->getData();
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user) {
                // Generate and set reset token
                $token = bin2hex(random_bytes(32));
                $user->setResetToken($token);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // Send email with reset link
                $resetLink = $this->generateUrl('reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                $message = (new \Swift_Message('Reset Password'))
                    ->setFrom('mandysarwat@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'project/reset_password.html.twig', // Your email template
                            ['token' => $token]
                        ),
                        'text/html'
                    );

                $mailer->send($message);

                $this->addFlash('success', 'An email with instructions to reset your password has been sent.');
            } else {
                $this->addFlash('danger', 'Email address not found.');
            }
        }

        return $this->render('project/forgotten_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/reset_password/{token}', name: 'reset_password')]
    public function resetPassword(Request $request, string $token): Response
    {
        // Retrieve user by reset token
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['resetToken' => $token]);

        if (!$user) {
            $this->addFlash('danger', 'Invalid reset token.');
            return $this->redirectToRoute('app_login');
        }

        // Handle password reset form submission
        // Add logic similar to the previous example to handle form submission and update the password.

        return $this->render('project/reset_password.html.twig', [
            'token' => $token,
        ]);
    }
}
