<?php

namespace App\Controller;

use App\Game\GameManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class APIGameController extends AbstractController
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    #[Route('/api/game', name:"api_game")]
    public function apiGame(
        SessionInterface $session
    ): Response {

        $gameManager = GameManager::gameManagerNew();
        if ($session->has('game')) {
            $gameManager = $session->get("game");
        }
        $session->set("game", $gameManager);

        $response = new Response();
        $data = ["player_cards" => $gameManager->getPlayerCardStringsParent(),
                "player_score" => $gameManager->getBestPlayerScore(),
                "house_cards" => $gameManager->getMachineCardStringsParent(),
                "house_score" => $gameManager->getBestMachineScore(),
                "status" => $gameManager->getGameStatus()];
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
}
