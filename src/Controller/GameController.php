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
    #region game start
    #[Route("/game", name: "game")]
    public function home(): Response
    {
        return $this->render('game/home.html.twig');
    }
    #endregion

    #region game docs
    #[Route("/game/doc", name: "game_docs")]
    public function game_docs(): Response
    {
        return $this->render('game/doc.html.twig');
    }

    #[Route("/game/restart", name: "game_restart")]
    public function game_restart(
        SessionInterface $session): Response
    {
        $session->remove("status");
        $session->remove("game");

        return $this->redirect('/game/play');
    }
    #endregion

    #region hit me
    #[Route("/game/hit_me", name: "game_hit")]
    public function game_hit(
        SessionInterface $session
    ): Response
    {
        if ($session->has('game'))
        {
            $gameManager = $session->get("game");
        } else {
            $gameManager = GameManager::gameManagerNew();
        }

        $status = $session->get("status") ?? "player_turn";
        if ($status == "player_turn")
        {
            $gameManager->drawPlayer();
        }

        if ($gameManager->checkPlayerHand() == "bust")
        {
            $session->set("status", "player_bust");
        } else if ($gameManager->checkPlayerHand() == "player_21")
        {
            $session->set("status", "player_21");
        }

        $session->set("game", $gameManager);

        return $this->redirect('/game/play');
    }
    #endregion

    #region play
    #[Route("/game/play", name: "game_play")]
    public function game_play(
        SessionInterface $session
    ): Response {

        if ($session->has('game'))
        {
            $gameManager = $session->get("game");
        } else {
            $gameManager = GameManager::gameManagerNew();
            $session->set("game", $gameManager);
        }
        $status = $session->get("status") ?? "player_turn";
        $session->set("status", $status);

        $colors = $gameManager->getPlayerCardColors();
        $cards = $gameManager->getPlayerCardStrings();

        $data = ["cards" => $cards,
        "cardColors" => $colors,
        "machine_cards" => [],
        "machineColors" => [],
        "status" => $status,
        "winner_phrase" => ""];
        return $this->render('game/play.html.twig', $data);
    }
    #endregion

    #region stay
    #[Route("/game/stay", name: "game_stay")]
    public function game_stay(
        SessionInterface $session
    ): Response {

        if ($session->has('game'))
        {
            $gameManager = $session->get("game");
        } else {
            $gameManager = GameManager::gameManagerNew();
            $session->set("game", $gameManager);
        }

        $gameManager->populateMachine();

        $status = $gameManager->getGameStatus();
        $session->set("status", $status);
    
        $colors = $gameManager->getPlayerCardColors();
        $cards = $gameManager->getPlayerCardStrings();

        $machineCards = $gameManager->getMachineCardStrings();
        $machineColors = $gameManager->getMachineCardColors();
        
        $winner_phrase = $gameManager->getWinnerPhrase();
        $data = ["cards" => $cards,
                "cardColors" => $colors,
                "machine_cards" => $machineCards,
                "machineColors" => $machineColors,
                "status" => $status,
                "winner_phrase" => $winner_phrase];
        return $this->render('game/play.html.twig', $data);
    }
    #endregion
    
}
