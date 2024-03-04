<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\PdfService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Service\TwilioService;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use App\Services\QrcodeService;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    private $twilioService;

   
    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ReservationRepository $reservation, QrcodeService $qrcodeService): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();
            // Générer le QR code
            $qrCode = $qrcodeService->createQrCode($reservation->getId());
           /**$userPhoneNumber = $reservation->getTelephone();
                $countryCode = '+216';
                $fullPhoneNumber = $countryCode . $userPhoneNumber;

                // Send the SMS
                 $this->twilioService->sendSms(
                    $fullPhoneNumber,
                     'Votre réservation a été bien enregistré !.'

                ); 
                */
            return $this->render('reservation/show.html.twig',[
                'reservation' => $reservation,
                'qrCode' => $qrCode, // Passer le QR code au template
            ]);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

    

    
    #[Route('/pdf/{id}', name: 'reservation.pdf')]
    public function generatePdfPersonne(Reservation $reservation = null, PdfService $pdf,QrcodeService $qrcodeService)
    {
        $qrCode = $qrcodeService->createQrCode($reservation->getId());
        $html = $this->renderView('reservation/showPdf.html.twig', [
            'reservation' => $reservation,
            'qrCode' => $qrCode,
        ]);
        $pdfContent = $pdf->generatePdfFile($html); // Assume que la méthode retourne le contenu du PDF
    
        $response = new Response($pdfContent);
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'reservation.pdf'
        );
        $response->headers->set('Content-Disposition', $disposition);
    
        return $response;
    }
    
    
}
