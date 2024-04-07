<?php

namespace App\Controller;

use App\Card\CardGraphic;
use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class APICardController extends AbstractController
{
    #[Route('/api/deck', name:"api_deck")]
    public function api_deck(
        SessionInterface $session
    ): Response {

        $deck = $session->get("deck") ?? new DeckOfCards();
        $session->set("deck", $deck);
        $cards = [];
        $colors = [];
        $values = $deck->getValues();
        sort($values);

        $card = new Card();

        foreach($values as $index) {
            $card->setValue($index);
            $cards[] = $card->getAsString();
            // $colors[] = $card->getAsColor();

        }
        $count = $deck->getNumberCards();

        $data = ["cards" => $cards];

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route("/capi/deck/shuffle", name: "api_show_shuffle", methods: ["POST"])]
    public function api_show_shuffle(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set("deck", $deck);
        $cards = [];
        $values = $deck->getValues();
        $card = new Card();

        foreach($values as $index) {
            $card->setValue($index);
            $cards[] = $card->getAsString();
        }

        $count = $deck->getNumberCards();

        $data = ["cards" => $cards,
                "size" => $count];
        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    #[Route("/api/deck/unsorted", name: "api_show_unsorted", methods: ["POST"])]
    public function api_show_unsorted(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck") ?? new DeckOfCards();
        $session->set("deck", $deck);
        $cards = [];
        $colors = [];
        $values = $deck->getValues();
        $card = new Card();

        foreach($values as $index) {
            $card->setValue($index);
            $cards[] = $card->getAsString();
        }

        $count = $deck->getNumberCards();

        $data = ["cards" => $cards,
                "size" => $count];

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route("/api/deck/draw", name: "api_draw", methods: ["POST"])]
    public function api_draw(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck") ?? new DeckOfCards();
        $values = $deck->giveHandValues(1);
        $session->set("deck", $deck);
        $cards = [];
        $colors = [];
        $card = new Card();

        foreach($values as $index) {
            $card->setValue($index);
            $cards[] = $card->getAsString();
            $colors[] = $card->getAsColor();
        }

        $count = $deck->getNumberCards();

        $data = ["cards" => $cards,
                "size" => $count];

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route("/api/deck/draw/{num<\d+>}", name: "api_draw_num", methods: ["POST"])]
    public function api_draw_num(
        string $num,
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck") ?? new DeckOfCards();
        $num = intval($num);
        $values = $deck->giveHandValues($num);
        $session->set("deck", $deck);
        $cards = [];
        $card = new Card();

        foreach($values as $index) {
            $card->setValue($index);
            $cards[] = $card->getAsString();
        }
        $count = $deck->getNumberCards();
        $data = ["cards" => $cards,
                "size" => $count];

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
