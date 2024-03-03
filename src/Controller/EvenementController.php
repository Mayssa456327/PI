<?php

namespace App\Controller;
use App\Entity\PdfGeneratorService;
use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Avis;
use App\Form\AvisType;
use App\Repository\AvisRepository;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    
    
    #[Route('/pdf', name: 'generator_service')]
    public function pdfService(EntityManagerInterface $entityManager): Response
    { 
        $evenements = $entityManager
        ->getRepository(Evenement::class)
        ->findAll();

        $html = $this->renderView('evenement/PdfEvenement.html.twig', ['evenements' => $evenements]);
        $pdfGeneratorService = new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
    }


    #[Route('/', name: 'app_evenement_index', methods: ['GET','POST'])]
    public function index(EntityManagerInterface $entityManager, EvenementRepository $evenementRepository, Request $request): Response
    {
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();

        $back = null;

        if ($request->isMethod("POST")) {
            if ($request->request->get('optionsRadios')) {
                $sortKey = $request->request->get('optionsRadios');
                switch ($sortKey) {
                    case 'nomEvenement':
                        $evenements = $evenementRepository->sortByNomEvenement();
                        break;

                    case 'dateDebut':
                        $evenements = $evenementRepository->sortByDateDebut();
                        break;

                    case 'lieuEvenement':
                        $evenements = $evenementRepository->sortByLieuEvenement();
                        break;
                }
            } else {
                $type = $request->request->get('optionsearch');
                $value = $request->request->get('Search');
                switch ($type) {
                    case 'nomEvenement':
                        $evenements = $evenementRepository->findByNomEvenement($value);
                        break;

                    case 'lieuEvenement':
                        $evenements = $evenementRepository->findByLieuEvenement($value);
                        break;

                    case 'dateDebut':
                        $evenements = $evenementRepository->findByDateDebut($value);
                        break;

                    case 'dateFin':
                        $evenements = $evenementRepository->findByDateFin($value);
                        break;
                }
            }

            $back = $evenements ? "success" : "failure";
        }

        return $this->render('admin1/indexB.html.twig', [
            'evenements' => $evenements,
            'back' => $back,
        ]);
    }

    #[Route('/front', name: 'app_evenement_indexFront', methods: ['GET'])]
    public function indexFront(EvenementRepository $evenementRepository,EntityManagerInterface $entityManager,Request $request,PaginatorInterface $paginator): Response
    {
        $user = $this->getUser();
        $evenements = $entityManager
        ->getRepository(Evenement::class)
        ->findAll();

            $evenements = $paginator->paginate(
            $evenements, /* query NOT result */
            $request->query->getInt('page', 1),
            3
        );

        
        

    return $this->render('evenement/indexFront.html.twig', [
        'evenements' => $evenements,
        'user' => $user,
    ]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        $formView = $form->createView();

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $evenement->getImageEvenement();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads'),$filename);
            $evenement->setImageEvenement($filename);
        $entityManager->persist($evenement);
        $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $formView,
            'user' => $user,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        $user = $this->getUser();
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
            'user' => $user,
        ]);
    }
    #[Route('/F/{id}', name: 'app_evenement_showF', methods: ['GET','POST'])]
    public function showF(Evenement $evenement,Request $request, EntityManagerInterface $entityManager,$id,EvenementRepository $evenementRepository,AvisRepository $avisRepository): Response
    {
        $user = $this->getUser();
        $avi = new Avis();
        $evenement = $evenementRepository->find($id);
        $averageRating = $avisRepository->getAverageRatingForEvenement($evenement);

        $avi->setEvenement($evenement);
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);
        $formView=$form->createView();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avi);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_showF', ['id' => $evenement->getId()], Response::HTTP_SEE_OTHER);        }

        
        return $this->render('evenement/showF.html.twig', [
            'evenement' => $evenement,
            'user' => $user,
            'avi' => $avi,
            'form' => $formView,
            'averageRating' => $averageRating,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        $formView = $form->createView();

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $evenement->getImageEvenement();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads'),$filename);
            $evenement->setImageEvenement($filename);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $formView,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/show_in_map/{id}', name: 'app_evenement_map', methods: ['GET'])]
    public function Map( Evenement $id,EntityManagerInterface $entityManager ): Response
    {

        $id = $entityManager
            ->getRepository(Evenement::class)->findBy( 
                ['id'=>$id ]
            );
        return $this->render('evenement/api_arcgis.html.twig', [
            'evenements' => $id,
        ]);
    }
}
