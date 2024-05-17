<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Proj\EntryLevel;
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

        $promptText = "After years of adventuring and searching you have finally found a way out of this forsaken world." .
        " You are certain that the portal to Elysium is in this house. You just need find it.";
    
        $items = ["Key" => [549/679, 550/679, "key"],
                    "Heavenly_Key" => [763/1024, 586/1024, "heavenly_key"]];
        $doors = ["Hatch" => [514/1024, 762/1024]];
        $image = "Room_DALL-E.webp";
    
        $entryLevel = new EntryLevel($promptText, $items, $doors, $image);
        $session->set("Level", $entryLevel);
        $heavenlyKey =$session->get("heavenly_key") ?? null;
        $key =$session->get("key") ?? null;


        $structures = ["image" => $entryLevel->getImage(),
        "prompt" => $entryLevel->getPrompt(),
        "key" => $key,
        "heavenlyKey" => $heavenlyKey];

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
        $heavenlyKey =$session->get("heavenly_key") ?? null;
        $key =$session->get("key") ?? null;

        $check = $level->checkCoord($xCoord, $yCoord);
        $promptText = $check;
        if ($check == "key" && $key != "yes") {
            $session->set("key", "yes");
            $promptText = "You found a key!";
            $key = "yes";
        } else if ($check =="heavenly_key" && $heavenlyKey != "yes")
        {
            $promptText = "You found the Heavenly Key!";
            $session->set("heavenly_key", "yes");
            $heavenlyKey = "yes";
        } else {
        }

        $structures = ["image" => $level->getImage(),
        "prompt" => $promptText,
        "key" => $key,
        "heavenlyKey" => $heavenlyKey];

        return $this->render('proj/about.html.twig', $structures);
    }
}
