<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class APIController extends AbstractController
{
    #[Route('/api', name: "api")]
    public function meStart(): Response
    {
        return $this->render('api.html.twig');
    }

    #[Route('/api/quote', name:"api_quote")]
    public function apiQuote(): Response
    {
        $number = random_int(0, 2);
        $quotes =  ["Flowers never bend with the rainfall.",
                    "All your base are belong to us.",
                    "It's not time to make a change. " .
                    "Just relax, take it easy. " .
                    "You're still young, that's your fault. " .
                    "There's so much you have to know."
        ];

        $data = [
            'quote' => $quotes[$number],
            'timeStamp' => date("Y-m-d H:i:s"),
        ];

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
