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
    #[Route('/proj/about', name: 'proj_about')]
    public function home(
        SessionInterface $session
        ): Response
    {

        $entryLevel = new EntryLevel();
        $session->set("Level", $entryLevel);
        $heavenlyKey =$session->get("heavenly_key") ?? false;
        $key =$session->get("key") ?? false;


        $structures = ["image" => $entryLevel->getImage(),
        "prompt" => $entryLevel->getPrompt(),
        "key" => $key,
        "heavenlyKey" => $heavenlyKey,
        "backButton" => $entryLevel->backButtonExists()];

        return $this->render('proj/about.html.twig', $structures);
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
        $promptText = $check;
        if ($check == "key" && $key == false) {
            $session->set("key", true);
            $promptText = "You found a key!";
            $key = true;
        } else if ($check =="heavenly_key" && $heavenlyKey == false)
        {
            $promptText = "You found the Heavenly Portal Opener!";
            $session->set("heavenly_key", true);
            $heavenlyKey = true;
        } else if ($check != "Nothing happened")
        {
            $level = $level->next($key, $heavenlyKey);
            $session->set("Level", $level);
            $promptText = $level->getPrompt();
        }

        $structures = ["image" => $level->getImage(),
        "prompt" => $promptText,
        "key" => $key,
        "heavenlyKey" => $heavenlyKey,
        "backButton" => $level->backButtonExists()];

        return $this->render('proj/about.html.twig', $structures);
    }

    
    #[Route('/proj/back', name: 'proj_back', methods: ['POST'])]
    public function back(
        Request $request,
        SessionInterface $session): Response
    {
        $level = $session->get("Level");
        $heavenlyKey =$session->get("heavenly_key") ?? null;
        $key =$session->get("key") ?? null;

        $level = $level->getBack();
        $session->set("Level", $level);

        $structures = ["image" => $level->getImage(),
        "prompt" => $level->getPrompt(),
        "key" => $key,
        "heavenlyKey" => $heavenlyKey,
        "backButton" => $level->backButtonExists()];

        return $this->render('proj/about.html.twig', $structures);
    }
}
