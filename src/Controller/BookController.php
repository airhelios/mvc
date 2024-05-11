<?php

namespace App\Controller;

use App\Form\BookFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;
use Symfony\Component\Filesystem\Filesystem;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @SuppressWarnings(Shortvariable)
 */
class BookController extends AbstractController
{
    #region index
    #[Route('/library', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #endregion

    #region create
    #[Route('/library/create', name: 'create_book')]
    public function create(
        Request $request,
        ManagerRegistry $doctrine,
        FileUploader $fileUploader,
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
        ->findAll();
        if (sizeof($books) >= 10) {
            return new Response('10 books or more in the library, delete one to add one');
        }
        $book = new Book();

        $form = $this->createForm(BookFormType::class, $book);
        $form->handleRequest($request);

        $entityManager = $doctrine->getManager();

        // Early return if the form is not submitted or is invalid
        if (!$form->isSubmitted() || !$form->isValid()) {
        return $this->render('book/create.html.twig', [
            'book_form' => $form->createView()]);
        }

        $imgFile = $form->get('img-upload')->getData();

        // Process the image file if it exists
        if ($imgFile) {
            $imgFileName = $fileUploader->upload($imgFile);
            $book->setImg($imgFileName);
        }

        // Persist and flush the entity
        $entityManager->persist($book);
        $entityManager->flush();

        // Redirect to the book by id
        return $this->redirectToRoute('book_by_id', ["id" => $book->getId()]);
        
        
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $imgFile = $form->get('img-upload')->getData();

        //     // this condition is needed because the 'img-upload' field is not required
        //     // so the img file must be processed only when a file is uploaded
        //     if ($imgFile) {
        //         $imgFileName = $fileUploader->upload($imgFile);
        //         $book->setImg($imgFileName);
        //     }

        //     $entityManager->persist($book);
        //     $entityManager->flush();
        //     return $this->redirectToRoute('book_by_id', ["id" => $book->getId()]);
        // }
        // return $this->render('book/create.html.twig', [
        //     'book_form' => $form->createView()
        // ]);
    }
    #endregion

    #region update
    #[Route('/library/update/{id}', name: 'update_book')]
    public function updateBook(
        Request $request,
        ManagerRegistry $doctrine,
        FileUploader $fileUploader,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        $form = $this->createForm(BookFormType::class, $book);
        $form->handleRequest($request);

        $entityManager = $doctrine->getManager();

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('book/update.html.twig', [
                'book' => $book,
                'book_form' => $form->createView()
            ]);
        }
        $book->setTitle($form->get('title')->getData());
        $book->setAuthor($form->get('author')->getData());
        $book->setISBN($form->get('ISBN')->getData());
            // dd($form->get('title')->getData());


        $imgFile = $form->get('img-upload')->getData();

            // this condition is needed because the 'img-upload' field is not required
            // so the img file must be processed only when a file is uploaded
        if ($imgFile) {
            $prevImage = $book->getImg();
            $imgFileName = $fileUploader->upload($imgFile);
            $book->setImg($imgFileName);
            $this->deleteImg($prevImage);   
        }
        $entityManager->flush();

        return $this->render('book/update.html.twig', [
            'book' => $book,
            'book_form' => $form->createView()
        ]);
    }

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $book->setTitle($form->get('title')->getData());
    //         $book->setAuthor($form->get('author')->getData());
    //         $book->setISBN($form->get('ISBN')->getData());
    //         // dd($form->get('title')->getData());


    //         $imgFile = $form->get('img-upload')->getData();

    //         // this condition is needed because the 'img-upload' field is not required
    //         // so the img file must be processed only when a file is uploaded
    //         if ($imgFile) {
    //             $prevImage = $book->getImg();
    //             $imgFileName = $fileUploader->upload($imgFile);
    //             $book->setImg($imgFileName);
    //             $this->deleteImg($prevImage);   
    //         }
    //     }
    //     $entityManager->flush();

    //     return $this->render('book/update.html.twig', [
    //         'book' => $book,
    //         'book_form' => $form->createView()
    //     ]);
    // }
    
    #endregion update

    #region show one
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
    #endregion

    #region show all
    #[Route('/library/show', name: 'book_show_all')]
    public function showAllBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        return $this->render('book/show_all.html.twig', [
            'books' => $books]);
    }
    #endregion

    #region delete one
    #[Route('/library/delete/{id}', name: 'book_delete_by_id', methods: ['POST'])]
    public function deleteBookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $image = $book->getImg();
        $this->deleteImg($image);

        // $filesystem = new Filesystem();

        // if ($image) {
        //     $path = $this->getParameter("img_directory").'/'.$image;
        //     $filesystem->remove($path);
        // }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_show_all');
    }
    #endregion

    #region reset
    /**
     * @SuppressWarnings(CountInLoopExpression)
     */
    #[Route('/library/reset', name: 'library_reset')]
    public function reset(
        BookRepository $bookRepository,
        ManagerRegistry $doctrine
    ): Response {

        $filesystem = new Filesystem();
        //Delete images
        $books = $bookRepository
        ->findAll();
        $copyImage = ["aurelius-1.jpg", "homeros-1.jpg", "musketeers-1.jpg", "suntzu-1.jpg"];
        $numBooks = count($books);
        for ($ind = 0; $ind < $numBooks; $ind++) {
            // $path = $this->getParameter("img_directory").'/'.$books[$ind]->getImg();
            // $filesystem->remove($path);
            $this->deleteImg($books[$ind]->getImg());
        }
        //Move default images
        $numImages = count($copyImage);
        for ($ind = 0; $ind < $numImages; $ind++) {
            $pathTo = $this->getParameter("img_directory").'/'.$copyImage[$ind];
            $pathFrom = $this->getParameter("img_directory").'/storage/'.$copyImage[$ind];
            $filesystem->copy($pathFrom, $pathTo);
        }

        $em = $doctrine->getManager();
        $connection = $em->getConnection();/* @phpstan-ignore-line */
        $sqlDrop = "DROP TABLE IF EXISTS book;";
        $stmt = $connection->prepare($sqlDrop);
        $stmt->executeStatement();

        $sqlTable = "
        CREATE TABLE book (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            title VARCHAR(255) NOT NULL,
            isbn VARCHAR(255) DEFAULT NULL,
            author VARCHAR(255) NOT NULL,
            img VARCHAR(255) DEFAULT NULL
        );";
        $stmt = $connection->prepare($sqlTable);
        $stmt->executeStatement();

        $sqlInsert = "        
        INSERT INTO book (id, title, isbn, author, img) VALUES 
        (1, 'Meditations', '0-3998-4298-5', 'Marcus Aurelius', 'aurelius-1.jpg'),
        (2, 'The Iliad', '0-1316-7204-5', 'Homer', 'homeros-1.jpg'),
        (3, 'Three Muskeeters', '0-7669-6438-8', 'Alexandre Dumas', 'musketeers-1.jpg'),
        (4, 'The Art of War', '0-2384-6943-3', 'Sun Tzu', 'suntzu-1.jpg');
        ;";
        $stmt = $connection->prepare($sqlInsert);
        $stmt->executeStatement();

        return $this->redirectToRoute('book_show_all');
    }

    protected function deleteImg(string $bookImage): void {
        if ($bookImage) {
            $filesystem = new Filesystem();
            $path = $this->getParameter("img_directory").'/'.$bookImage;
            $filesystem->remove($path);
        }
    }
}
