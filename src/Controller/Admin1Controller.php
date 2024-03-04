<?php

namespace App\Controller;

use App\Entity\PdfGeneratorService;
use App\Service\PdfGenerator2;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\EventListener\PasswordListener;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Knp\Snappy\Pdf;
use App\Service\PdfGenerator;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use App\Repository\HopitalRepository;
use App\Repository\ReservationRepository;




class   Admin1Controller extends AbstractController
{
    #[Route('/admin1', name: 'app_admin1_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin1/index.html.twig', [
            'controller_name' => 'Admin1Controller',
        ]);
    }
    #[Route('/hopitaladmin', name: 'Hopital_list', methods: ['GET'])]
    public function Hopital(HopitalRepository $hopitalRepository): Response
    {
        return $this->render('admin1/hopitalList.html.twig', [
            'hopitals' => $hopitalRepository->findAll(),
        ]);
    }
    #[Route('/reservationList', name: 'reservation_list', methods: ['GET'])]
    public function Reservations(ReservationRepository $reservationRepository): Response
    {
        return $this->render('admin1/reservationList.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }
    #[Route('/listTrie', name: 'list_trie')]
    public function listTrie(HopitalRepository $repository)
    {

        $hopitals = $repository->findAll();
        $HopitalByNom = $repository->sortByNom();
        return $this->render(
            "admin1/hopitalTrier.html.twig",
            array(
                'hopitals' => $hopitals,
                'hopitalByNom' => $HopitalByNom,
            )
        );
    }

    #[Route('/chambreTrie', name: 'chambre_trie')]
    public function chambreTrie(HopitalRepository $repository)
    {

        $hopitals = $repository->findAll();
        $HopitalByChambre = $repository->sortByNombreChambre();
        return $this->render(
            "admin1/chambreTrie.html.twig",
            array(
                'hopitals' => $hopitals,
                'hopitalByChambre' => $HopitalByChambre,
            )
        );
    }

    #[Route('/searchHopital', name: 'cherche_nom')]
    public function search(Request $request, HopitalRepository $repository)
    {
        $searchTerm = $request->query->get('search');
        $hopitals = $repository->findBySearchTerm($searchTerm);

        return $this->render('admin1/hopitalList.html.twig', [
            'hopitals' => $hopitals
        ]);
    }

    #[Route('/reservationTrie', name: 'reservation_trie')]
    public function reservationTrie(ReservationRepository $repository)
    {

        $reservations = $repository->findAll();
        $ReservationByDate = $repository->sortByDate();
        return $this->render(
            "admin1/reservationTrie.html.twig",
            array(
                'Reservation' => $reservations,
                'ReservationByDate' => $ReservationByDate,
            )
        );
    }

    #[Route('/searchReservation', name: 'cherche_reservation')]
    public function recherche(Request $request, ReservationRepository $repository)
    {
        $searchTerm = $request->query->get('search');
        $reservations = $repository->findBySearchTerm($searchTerm);

        return $this->render('admin1/reservationList.html.twig', [
            'reservations' => $reservations
        ]);
    }


    /**
     * @Route("/pdf", name="PDF_User", methods={"GET"})
     */
    /**public function pdf(EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager
            ->getRepository(User::class)
            ->findAll();

        $html = $this->renderView('admin1/PdfUsers.html.twig', ['users' => $user]);
        $pdfGeneratorService = new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
    }
     */
    private function getCitiesFromDatabase(EntityManagerInterface $entityManager)
    {
        // Exemple de requête pour récupérer les villes
        $query = $entityManager->createQuery('
            SELECT DISTINCT u.ville
            FROM App\Entity\User u
        ');

        return $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }



    /*
    #[Route('/admin1/new', name: 'app_admin1_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode le mot de passe avant de le définir
            $this->encodePassword($user, $passwordEncoder);
            // handle profile image upload
            $profileImageFile = $form->get('profileImageFile')->getData();
            if ($profileImageFile) {
                $this->handleProfileImageUpload($profileImageFile, $user);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin1_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin1/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    */

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    /**#[Route('admin1/{id}', name: 'app_admin1_show', methods: ['GET'])]
    public function show(User $user,UserRepository $userRepository): Response
    {
         $userCount = $userRepository->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
        return $this->render('admin1/show.html.twig', [
            'user' => $user,
            'userCount' => $userCount,
        ]);
    }
     */

    /*  #[Route('admin1/{id}/edit', name: 'app_admin1_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, EntityManagerInterface $entityManager,  UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode le mot de passe
            $this->encodePassword($user, $passwordEncoder);
            // handle profile image upload
            $profileImageFile = $form->get('profileImageFile')->getData();
            if ($profileImageFile) {
                $this->handleProfileImageUpload($profileImageFile, $user);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin1/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    */
    /**#[Route('medecin/{id}/edit', name: 'app_medecin_edit', methods: ['GET', 'POST'])]
    public function editMedecin(Request $request, int $id, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode le mot de passe
            $this->encodePassword($user, $passwordEncoder);
            // handle profile image upload
            $profileImageFile = $form->get('profileImageFile')->getData();
            if ($profileImageFile) {
                $this->handleProfileImageUpload($profileImageFile, $user);
            }

            $entityManager->flush();

            return $this->redirectToRoute('medecin_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medecin/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('patient/{id}/edit', name: 'app_patient_edit', methods: ['GET', 'POST'])]
    public function editpatient(Request $request, int $id, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode le mot de passe
            $this->encodePassword($user, $passwordEncoder);
            // handle profile image upload
            $profileImageFile = $form->get('profileImageFile')->getData();
            if ($profileImageFile) {
                $this->handleProfileImageUpload($profileImageFile, $user);
            }

            $entityManager->flush();

            return $this->redirectToRoute('patient_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    private function handleProfileImageUpload(UploadedFile $file, User $user): void
    {
        $newFilename = md5(uniqid()).'.'.$file->guessExtension();

        try {
            $file->move(
                $this->getParameter('profile_images_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            $this->addFlash('error', 'An error occurred while uploading the image.');
            // handle the exception as needed
        }

        $user->setProfileImage($newFilename);
    }
    private function encodePassword(User $user, UserPasswordEncoderInterface $passwordEncoder): void
    {
        $plainPassword = $user->getPassword();
        if (!empty($plainPassword)) {
            $encodedPassword = $passwordEncoder->encodePassword($user, $plainPassword);
            $user->setPassword($encodedPassword);
        }
    }

    #[Route('admin1/{id}', name: 'app_admin1_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin1_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/user/change-status/{id}', name: 'change_user_status')]
    public function changeUserStatus(User $user): Response
    {
        // Inversez le statut de l'utilisateur
        $user->setStatus(!$user->getStatus());

        // Enregistrez les modifications
        $this->getDoctrine()->getManager()->flush();

        // Redirigez l'utilisateur vers la page des utilisateurs (ou toute autre page souhaitée)
        return $this->redirectToRoute('app_admin1_index');
    }
     */

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    /**#[Route('/user-stats/{role}', name: 'user_stats')]
    public function userStats($role, UserRepository $userRepository): Response
    {
        $userCount = $userRepository->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.role = :role')
            ->setParameter('role', $role)
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('admin1/user_stats.html.twig', [
            'userCount' => $userCount,
            'role' => $role,
        ]);
    }*/
}
