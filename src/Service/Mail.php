<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mail
{
    public function sendEmail(MailerInterface $mailer): Response
    {


        $email = (new Email())
            ->from('info@niftyone.com')
            ->to('aminejabeur99@gmail.com')
            ->subject('new blog added!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');



        try {
            $mailer->send($email);
            echo 'testttttt';
            #die;
            // Si l'email est envoyé avec succès, vous pouvez retourner un code 200 (OK) ou 202 (Accepted).
            return new Response('Email sent successfully', Response::HTTP_OK);
        } catch (TransportExceptionInterface $e) {
            // Si une erreur se produit lors de l'envoi, retournez un code 500 (Internal Server Error) ou tout autre code d'erreur approprié.
            #return new Response('Failed to send email', Response::HTTP_INTERNAL_SERVER_ERROR);
            print_r($e);

        }
            die;


        // Retournez une réponse ou redirigez l'utilisateur si nécessaire
        #return new Response('Email sent!');
    }
}