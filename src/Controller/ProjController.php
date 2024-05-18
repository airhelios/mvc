<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Proj\EntryLevel;
use App\Proj\HatchLevel;
/**
 * @SuppressWarnings(Shortvariable)
 */
class ProjController extends AbstractController
{
    #region home
    #[Route('/proj', name: 'proj_home')]
    public function index(): Response
    {
        return $this->render('proj/index.html.twig');
    }
    #endregion

    #region about
    #[Route('/proj/play', name: 'proj_play')]
    public function home(
        SessionInterface $session
        ): Response
    {

        // $entryLevel = new EntryLevel();
        $level = $session->get("Level") ?? new EntryLevel();
        $session->set("Level", $level);
        $heavenlyKey =$session->get("heavenly_key") ?? false;
        $key =$session->get("key") ?? false;


        $structures = ["image" => $level->getImage(),
        "prompt" => $level->getPrompt(),
        "key" => $key,
        "heavenlyKey" => $heavenlyKey,
        "backButton" => $level->backButtonExists()];

        return $this->render('proj/play.html.twig', $structures);
    }
    #endregion

    #[Route('/proj/check', name: 'proj_check', methods: ['POST'])]
    public function check(
        Request $request,
        SessionInterface $session): Response
    {

        $xCoord = $request->request->get('xCoord');
        $yCoord = $request->request->get('yCoord');
        $level = $session->get("Level");
        $heavenlyKey =$session->get("heavenly_key") ?? false;
        $key =$session->get("key") ?? false;
        $check = $level->checkCoord($xCoord, $yCoord);

        $level->setPrompt($check);
        if ($check == "key" && $key == false) {
            $session->set("key", true);
            $level->setPrompt("You found a key!");
            $key = true;
        } else if ($check =="heavenly_key" && $heavenlyKey == false)
        {
            $level->setPrompt("You found the Heavenly Portal Opener!");
            $session->set("heavenly_key", true);
            $heavenlyKey = true;
        } else if ($check == "Hell")
        {
            $level = $level->next($key, $heavenlyKey, "Hell");
        } else if ($check != "Nothing happened")
        {
            $level = $level->next($key, $heavenlyKey);
        }

        $session->set("Level", $level);
        return $this->redirectToRoute('proj_play');
    }

    #region go back
    #[Route('/proj/back', name: 'proj_back', methods: ['POST'])]
    public function back(
        SessionInterface $session): Response
    {
        $level = $session->get("Level");
        $level = $level->previous(); 
        $session->set("Level", $level);

        return $this->redirectToRoute('proj_play');
    }
    #endregion
}
