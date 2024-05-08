<?php

namespace App\Controller;

use App\Game\GameManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;

class APILibraryController extends AbstractController
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    #[Route('/api/library/books', name:"api_library_all")]
    public function apiLibraryAll(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        $response = new Response();
        // $response->setContent(json_encode($books));
        $response = $this->json($books);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
    
        return $response;
    }

    #[Route('/api/library/isbn/{ISBN}', name:"api_library_isbn")]
    public function apiLibraryISBN(
        BookRepository $bookRepository,
        string $ISBN
    ): Response {
        $books = $bookRepository
            ->findByISBN($ISBN);

        $response = new Response();
        // $response->setContent(json_encode($books));
        $response = $this->json($books);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
    
        return $response;
    }
}