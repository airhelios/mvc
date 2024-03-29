<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class LuckyController extends AbstractController
{
    #[Route('/lucky', name: "lucky")]
    public function number(): Response
    {
        $number = random_int(0, 100);
        $imgNumber = random_int(1, 6);


        $data = [
            'number' => $number,
            'imgNumber' => $imgNumber
        ];

        return $this->render('lucky.html.twig', $data);
    }

}
