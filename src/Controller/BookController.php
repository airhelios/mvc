<?php

namespace App\Controller;

use App\Form\BookFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;




use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookController extends AbstractController
{
    #[Route('/library', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/library/create', name: 'create_book')]
    public function create(
        Request $request,
        ManagerRegistry $doctrine,
        FileUploader $fileUploader)
    {
        $book = new Book();

        $form = $this->createForm(BookFormType::class, $book);
        $form->handleRequest($request);

        $entityManager = $doctrine->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $imgFile = $form->get('img-upload')->getData();

            // this condition is needed because the 'img-upload' field is not required
            // so the img file must be processed only when a file is uploaded
            if ($imgFile) {
                $img = $form->get('img-upload')->getData();
                if ($img) {
                    $imgFileName = $fileUploader->upload($img);
                    $book->setImg($imgFileName);
                }
            }

            $entityManager->persist($book);
            $entityManager->flush();
            return new Response("Book with title " . $book->getTitle() . " has been created!");
        }
        return $this->render('book/create.html.twig', [
            'book_form' => $form->createView()
        ]);

    }
}
