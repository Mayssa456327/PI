<?php

namespace App\Controller;

use App\Entity\Blog;

use App\Form\Blog1Type;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\Mail;
use App\Service\SmsService;


use App\Entity\Comment;
use App\Form\BlogType;
use App\Form\CommentType;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

use App\Repository\CommentRepository;
#[Route('/blog')]
class BlogController extends AbstractController
{
    
    #[Route('/', name: 'app_blog_index', methods: ['GET'])]
    public function index(BlogRepository $blogRepository,PaginatorInterface $paginator,Request $request): Response
    {
        $blogs = $blogRepository->findAll();
         $blogss=$paginator->paginate(
            $blogs, /* query NOT result */
            $request->query->getInt('page', 1),
            3
        );
        $user = $this->getUser();
        return $this->render('blog/index.html.twig', [
            'blogs' => $blogss,
            'user' => $user,
        ]);
    }

    #[Route('/new', name: 'app_blog_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        
        $user = $this->getUser();
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        $formView = $form->createView();

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $fileName = uniqid().'.'.$file->guessExtension();
           
            
            // Move the file to the directory where your images are stored
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            $blog->setImage($fileName);
            $blog->setDate(new \DateTime());


            $entityManager->persist($blog);
            $entityManager->flush();
                    $mail=new Mail();
                    $mail->sendEmail($mailer);

            return $this->redirectToRoute('app_blog_indexback', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/new.html.twig', [
            'blog' => $blog,
            'form' => $formView,
            'user' => $user,
        ]);
    }


    #[Route('/{id}', name: 'app_blog_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Blog $blog, EntityManagerInterface $entityManager,SmsService $twilioService): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
             $to = '+21694687669'; // Replace with the recipient's phone number
             $message = 'Blog has been successfully added By '.$user->getNom().' .';
             $twilioService->sendSms($to, $message);
            $comment->setBlog($blog);
            $comment->setDate(new \DateTime());
            $comment->setLikes(0);
            $entityManager->persist($comment);
            $entityManager->flush();
            $user = $this->getUser();
            // Redirect to some route after form submission
            return $this->redirectToRoute('app_blog_show', ['id' => $blog->getId()]);
        }

        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_blog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blog $blog, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        $formView = $form->createView();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $formView,
            'user' => $user,
        ]);
    }

    // #[Route('/{id}', name: 'app_blog_delete', methods: ['GET','DELETE'])]
    // public function delete(, EntityManagerInterface $entityManager): Response
    // {
    //     #if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
    //         $blog = this->BlogRepository->find()
    //         $entityManager->remove($blog);
    //         $entityManager->flush();
    //     #}

    //     return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
    // }

 
  
        #[Route('/delete/{id}', name:'app_blog_delete', methods: ['POST'] )]
     
    public function delete(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $entity = $entityManager->getRepository(Blog::class)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No entity found for id '.$id);
        }

        // CSRF token validation (optional but recommended for security)
        // Assuming your deletion form sends a token named 'delete_token'
        if ($this->isCsrfTokenValid('delete'.$entity->getId(), $request->request->get('_token'))) {
            $entityManager->remove($entity);
            $entityManager->flush();
            
            $this->addFlash('success', 'The entity was successfully deleted.');
        } else {
            $this->addFlash('error', 'Invalid CSRF token.');
        }

        return $this->redirectToRoute('app_blog_indexback', [], Response::HTTP_SEE_OTHER);
    }




    #[Route('/{id}/like', name: 'app_comment_like')]
    public function like(int $id, Comment $comment, EntityManagerInterface $entityManager): Response
    {
        $comment->incrementLikes();
        $entityManager->flush();

        return $this->redirectToRoute('app_blog_show', [
            'id' => $comment->getBlog()->getId()
        ]);
    }
}
