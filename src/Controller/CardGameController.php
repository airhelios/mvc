<?php

namespace App\Controller;

use App\Card\CardGraphic;
use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }

    #[Route("/card/deck", name: "deck_show")]
    public function cardShowDeck(
        SessionInterface $session
    ): Response {

        $deck = $session->get("deck") ?? new DeckOfCards();
        $session->set("deck", $deck);
        $cards = [];
        $colors = [];
        $values = $deck->getValues();
        sort($values);

        $card = new CardGraphic();

        foreach($values as $index) {
            $card->setValue($index);
            $cards[] = $card->getAsString();
            $colors[] = $card->getAsColor();

        }
        $count = $deck->getNumberCards();

        $data = ["cards" => $cards,
        "cardColors" => $colors,
        "size" => $count,
        "page" => "Sorted"];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "deck_show_shuffle")]
    public function cardShowShuffle(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set("deck", $deck);
        $cards = [];
        $colors = [];
        $values = $deck->getValues();
        $card = new CardGraphic();
        $count = $deck->getNumberCards();

        foreach($values as $index) {
            $card->setValue($index);
            $cards[] = $card->getAsString();
            $colors[] = $card->getAsColor();
        }

        $data = ["cards" => $cards,
                "cardColors" => $colors,
                "size" => $count,
               "page" => "Shuffle"]    ;

        return $this->render('card/deck.html.twig', $data);
    }


    #[Route("/card/deck/unsorted", name: "deck_show_unsorted")]
    public function cardShowUnsorted(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck") ?? new DeckOfCards();
        $session->set("deck", $deck);
        $cards = [];
        $colors = [];
        $values = $deck->getValues();
        $card = new CardGraphic();

        foreach($values as $index) {
            $card->setValue($index);
            $cards[] = $card->getAsString();
            $colors[] = $card->getAsColor();
        }

        $count = $deck->getNumberCards();

        $data = ["cards" => $cards,
                "cardColors" => $colors,
                "size" => $count,
               "page" => "Unsorted"];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "deck_draw")]
    public function cardDraw(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck") ?? new DeckOfCards();
        $values = $deck->giveHandValues(1);
        $session->set("deck", $deck);
        $cards = [];
        $colors = [];
        $card = new CardGraphic();

        foreach($values as $index) {
            $card->setValue($index);
            $cards[] = $card->getAsString();
            $colors[] = $card->getAsColor();
        }

        $count = $deck->getNumberCards();

        $data = ["cards" => $cards,
                "cardColors" => $colors,
                "size" => $count,
               "page" => "Draw One"]    ;

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "deck_draw_num")]
    public function cardDrawNum(
        string $num,
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck") ?? new DeckOfCards();
        $num = intval($num);
        $values = $deck->giveHandValues($num);
        $session->set("deck", $deck);
        $cards = [];
        $colors = [];
        $card = new CardGraphic();

        foreach($values as $index) {
            $card->setValue($index);
            $cards[] = $card->getAsString();
            $colors[] = $card->getAsColor();
        }
        $count = $deck->getNumberCards();
        $data = ["cards" => $cards,
                "cardColors" => $colors,
                "size" => $count,
               "page" => "Draw One"]    ;

        return $this->render('card/deck.html.twig', $data);
    }

}
