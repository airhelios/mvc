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
            return new Response("Book with title " . $book->getTitle() . " and id" . $book->getId() . " has been created!");
        }
        return $this->render('book/create.html.twig', [
            'book_form' => $form->createView()
        ]);
    }

    #[Route('/library/update/{id}', name: 'update_book')]
    public function updateBook(
        Request $request,
        ManagerRegistry $doctrine,
        FileUploader $fileUploader,
        BookRepository $bookRepository,
        int $id)
    {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        $form = $this->createForm(BookFormType::class, $book);
        $form->handleRequest($request);



        $entityManager = $doctrine->getManager();
        // dd("HEEEEEJ");
        if ($form->isSubmitted() && $form->isValid()) {
            $book->setTitle($form->get('title')->getData());
            $book->setAuthor($form->get('author')->getData());
            $book->setISBN($form->get('ISBN')->getData());
            // dd($form->get('title')->getData());
   

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

            // $entityManager->persist($book);
            $entityManager->flush();
        }
        return $this->render('book/update.html.twig', [
            'book' => $book,
            'book_form' => $form->createView()
        ]);
    }

    #[Route('/library/show/{id}', name: 'book_by_id')]
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        return $this->render('book/show_one.html.twig', [
                'book' => $book]);
    }

    #[Route('/library/show', name: 'book_show_all')]
    public function showAllBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        return $this->json($books);
    }
}
