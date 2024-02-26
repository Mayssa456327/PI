<?php

namespace App\Controller;

use App\Service\PdfGenerator2;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
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

// Top of your controller file




use Knp\Snappy\Pdf;
use App\Service\PdfGenerator;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;



class   Admin1Controller extends AbstractController
{
    #[Route('/admin1', name: 'app_admin1_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nom = $request->query->get('nom');
        $prenom = $request->query->get('prenom');
        $ville = $request->query->get('ville');
        $tri = $request->query->get('tri');

        $userRepository = $entityManager->getRepository(User::class);
        $usersQuery = $userRepository->createQueryBuilder('u');

        if ($nom) {
            $usersQuery->andWhere('u.nom LIKE :nom');
            $usersQuery->setParameter('nom', '%' . $nom . '%');
        }

        if ($prenom) {
            $usersQuery->andWhere('u.prenom LIKE :prenom');
            $usersQuery->setParameter('prenom', '%' . $prenom . '%');
        }

        if ($ville) {
            $usersQuery->andWhere('u.ville LIKE :ville');
            $usersQuery->setParameter('ville', '%' . $ville . '%');
        }

        $users = $usersQuery->getQuery()->getResult();

        return $this->render('admin1/index.html.twig', [
            'users' => $users,
        ]);
    }
    #[Route('/listTrie', name: 'list_trie')]
    public function listTrie(UserRepository $repository,EntityManagerInterface $entityManager)
    {

        $users= $repository->findAll();
        $UserByNom= $repository->sortByNom();
        return $this->render("admin1/indexTrie.html.twig"
            ,array('users' => $users,
                'tabUserByNom'=>$UserByNom,
            ));
    }
    /**
     * @Route("/pdf", name="PDF_User", methods={"GET"})
     */
    public function pdf(UserRepository $UserRepository)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('admin1/index.html.twig', [
            'users' => $UserRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("ListeDesUsers.pdf", [
            "users" => true
        ]);
    }

    private function getCitiesFromDatabase(EntityManagerInterface $entityManager)
    {
        // Exemple de requête pour récupérer les villes
        $query = $entityManager->createQuery('
            SELECT DISTINCT u.ville
            FROM App\Entity\User u
        ');

        return $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }


    

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

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('admin1/{id}', name: 'app_admin1_show', methods: ['GET'])]
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

    #[Route('admin1/{id}/edit', name: 'app_admin1_edit', methods: ['GET', 'POST'])]
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
    #[Route('medecin/{id}/edit', name: 'app_medecin_edit', methods: ['GET', 'POST'])]
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

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/user-stats/{role}', name: 'user_stats')]
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
    }
}
