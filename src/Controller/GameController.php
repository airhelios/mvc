<?php

namespace App\Controller;

use App\Game\CardGraphicG;
use App\Game\CardG;
use App\Game\CardHandG;
use App\Game\DeckOfCardsG;
use App\Game\GameManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends AbstractController
{
    #[Route("/game", name: "game")]
    public function home(): Response
    {
        return $this->render('game/home.html.twig');
    }

    #[Route("/game/doc", name: "game_docs")]
    public function game_docs(): Response
    {
        return $this->render('game/doc.html.twig');
    }

    #[Route("/game/hit_me", name: "game_hit")]
    public function game_hit(
        SessionInterface $session
    ): Response
    {
        if ($session->has('game'))
        {
            $gameManager = $session->get("game");
        } else {
            $deck = new DeckOfCardsG();
            $playerHand = new CardHandG();
            $machineHand = new CardHandG();
            $gameManager = new GameManager($playerHand, $machineHand, $deck);
        }
        $gameManager->drawPlayer();
        $session->set("game", $gameManager);

        return $this->redirect('/game/play');
    }

    #[Route("/game/play", name: "game_play")]
    public function game_play(
        SessionInterface $session
    ): Response {

        if ($session->has('game'))
        {
            $gameManager = $session->get("game");
        } else {
            $deck = new DeckOfCardsG();
            var_dump($deck->getValues());

            $playerHand = new CardHandG();
            $machineHand = new CardHandG();
            $gameManager = new GameManager($playerHand, $machineHand, $deck);
            $session->set("game", $gameManager);
        }

        $playerCards = $gameManager->getPlayerHand();

        $colors = [];
        $cards = [];

        foreach($playerCards as $card) {
            $cards[] = $card->getAsString();
            $colors[] = $card->getAsColor();
        }
        // $count = $deck->getNumberCards();
        $sum = $gameManager->getScore("player");
        var_dump($sum);
        $data = ["cards" => $cards,
                "cardColors" => $colors,
            "sum" => $sum];
        return $this->render('game/play.html.twig', $data);
    }
}
