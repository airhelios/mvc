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

/**
* @SuppressWarnings(PHPMD.StaticAccess)
*/
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
    public function gameDocs(): Response
    {
        return $this->render('game/doc.html.twig');
    }

    #[Route("/game/restart", name: "game_restart")]
    public function gameRestart(
        SessionInterface $session
    ): Response {
        $session->remove("status");
        $session->remove("game");

        return $this->redirect('/game/play');
    }
    #endregion

    #region hit me
    #[Route("/game/hit_me", name: "game_hit")]
    public function gameHit(
        SessionInterface $session
    ): Response {
        $gameManager = GameManager::gameManagerNew();
        if ($session->has('game')) {
            $gameManager = $session->get("game");
        }

        $status = $session->get("status") ?? "player_turn";
        if ($status == "player_turn") {
            $gameManager->drawPlayer();
        }

        if ($gameManager->checkPlayerHand() == "bust") {
            $session->set("status", "player_bust");
        } elseif ($gameManager->checkPlayerHand() == "player_21") {
            $session->set("status", "player_21");
        }

        $session->set("game", $gameManager);

        return $this->redirect('/game/play');
    }
    #endregion

    #region play
    #[Route("/game/play", name: "game_play")]
    public function gamePlay(
        SessionInterface $session
    ): Response {

        $gameManager = GameManager::gameManagerNew();
        if ($session->has('game')) {
            $gameManager = $session->get("game");
        }
        $session->set("game", $gameManager);
        $status = $session->get("status") ?? "player_turn";
        $session->set("status", $status);

        $colors = $gameManager->getPlayerCardColors();
        $cards = $gameManager->getPlayerCardStrings();

        $data = ["cards" => $cards,
        "cardColors" => $colors,
        "machine_cards" => [],
        "machineColors" => [],
        "status" => $status,
        "winnerPhrase" => ""];
        return $this->render('game/play.html.twig', $data);
    }
    #endregion

    #region stay
    #[Route("/game/stay", name: "game_stay")]
    public function gameStay(
        SessionInterface $session
    ): Response {

        $gameManager = GameManager::gameManagerNew();
        if ($session->has('game')) {
            $gameManager = $session->get("game");
        }
        $gameManager->setPlayerMachine();
        $session->set("game", $gameManager);

        $gameManager->populateMachine();

        $status = $gameManager->getGameStatus();
        $session->set("status", $status);

        $colors = $gameManager->getPlayerCardColors();
        $cards = $gameManager->getPlayerCardStrings();

        $machineCards = $gameManager->getMachineCardStrings();
        $machineColors = $gameManager->getMachineCardColors();

        $winnerPhrase = $gameManager->getWinnerPhrase();
        $data = ["cards" => $cards,
                "cardColors" => $colors,
                "machine_cards" => $machineCards,
                "machineColors" => $machineColors,
                "status" => $status,
                "winnerPhrase" => $winnerPhrase];
        return $this->render('game/play.html.twig', $data);
    }
    #endregion

}
