<?php

namespace App\Controller;
use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use App\Repository\CommentRepository;
use App\Service\Mail;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Hazem;
use App\Form\HazemType;
use App\Repository\HazemRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backadmin')]
class BackAdmin1Controller extends AbstractController
{
    
//    #[Route('/', name: 'app_backadmin')]
//    public function index(): Response
//    {
//        return $this->render('backadmin/index.html.twig', [
//            'controller_name' => 'BackadminController',
//        ]);
//    }
#[Route('/', name: 'app_blog_indexback', methods: ['GET'])]
public function indexback(Request $request, BlogRepository $blogRepository): Response
{
    $searchQuery = $request->query->get('search');

    if ($searchQuery !== null) {
        $blogs = $blogRepository->findBySearchQuery($searchQuery);
    } else {
        // If no search query provided, retrieve all blogs
        $blogs = $blogRepository->findAll();
    }

    return $this->render('backadmin/index.html.twig', [
        'blogs' => $blogs,
    ]);
}
#[Route('/sorted/aaaaaaaaaaaaaaaaa', name: 'app_blog_index_sorted', methods: ['GET'])]
public function indexSorted(BlogRepository $blogRepository): Response
{
    $blogs = $blogRepository->findAllOrderedByDate();

    return $this->render('backadmin/index.html.twig', [
        'blogs' => $blogs,
    ]);
}
#[Route('/top-blogs/aaaaaaaaa', name: 'top_blogs', methods: ['GET'])]
public function topBlogs(BlogRepository $blogRepository): Response
{
    $topBlogs = $blogRepository->findTop3BlogsByCommentCount();

    return $this->render('backadmin/top_blogs.html.twig', [
        'topBlogs' => $topBlogs,
    ]);
}
#[Route('/newww', name: 'app_blog_newback', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
{
    $blog = new Blog();
    $form = $this->createForm(BlogType::class, $blog);
    $form->handleRequest($request);

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

    return $this->render('backadmin/new.html.twig', [
        'blog' => $blog,
        'form' => $form,
    ]);
}


#[Route('/{id}/edit', name: 'app_blog_editback', methods: ['GET', 'POST'])]
public function editback(Request $request, Blog $blog, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(BlogType::class, $blog);
    $form->handleRequest($request);
    $formView = $form->createView();

    if ($form->isSubmitted() && $form->isValid()) {
        $file = $form['image']->getData();

        // Check if a new image file is uploaded
        if ($file) {
            $fileName = uniqid().'.'.$file->guessExtension();

            // Move the file to the directory where your images are stored
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            // Set the new image file name
            $blog->setImage($fileName);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_blog_indexback', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('backadmin/edit.html.twig', [
        'blog' => $blog,
        'form' => $formView,
    ]);
}


#[Route('/back/{id}', name: 'app_blog_showback', methods: ['GET'])]
public function showback(Blog $blog): Response
{
    return $this->render('backadmin/show.html.twig', [
        'blog' => $blog,
    ]);
}
    #[Route('/topLikedComments', name: 'topLikedComments', methods: ['GET'])]
    public function topLikedComments(CommentRepository $commentRepository): Response
    {
        $topLikedComments = $commentRepository->findTopLikedComments();

        return $this->render('backadmin/top_liked_comments.html.twig', [
            'topLikedComments' => $topLikedComments,
        ]);
    }
}
