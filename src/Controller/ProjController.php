<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\ScoreForm;
use App\Entity\Saved;
use App\Entity\Condemned;

use App\Entity\IPLogger;


use App\Proj\EntryLevel;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;
use DateTimeZone;

/**
 * @SuppressWarnings(Shortvariable)
 */
class ProjController extends AbstractController
{
    #region home
    #[Route('/proj', name: 'proj_home')]
    public function index(
        Session $session
    ): Response {
        $session->set("Level", new EntryLevel());
        $session->set("key", false);
        $session->set("heavenly_key", false);
        return $this->redirectToRoute('proj_play');
    }
    #endregion

    #region about
    #[Route('/proj/about', name: 'proj_about')]
    public function about(): Response
    {
        return $this->render('proj/about.html.twig');
    }
    #endregion

    #region about
    #[Route('/proj/cheat', name: 'proj_cheat')]
    public function cheat(): Response
    {
        return $this->render('proj/cheat.html.twig');
    }
    #endregion

    #region database
    #[Route('/proj/about/database', name: 'proj_database')]
    public function database(): Response
    {
        return $this->render('proj/database.html.twig');
    }
    #endregion


    #region play
    #[Route('/proj/play', name: 'proj_play')]
    public function home(
        Session $session
    ): Response {

        // $entryLevel = new EntryLevel();
        $level = $session->get("Level") ?? new EntryLevel();
        $session->set("Level", $level);
        $heavenlyKey = $session->get("heavenly_key") ?? false;
        $key = $session->get("key") ?? false;


        $structures = ["image" => $level->getImage(),
        "prompt" => $level->getPrompt(),
        "key" => $key,
        "heavenlyKey" => $heavenlyKey,
        "backButton" => $level->backButtonExists()];

        return $this->render('proj/play.html.twig', $structures);
    }
    #endregion

    #region check click
    #[Route('/proj/check', name: 'proj_check', methods: ['POST'])]
    public function check(
        Request $request,
        Session $session
    ): Response {

        $xCoord = $request->request->get('xCoord');
        $yCoord = $request->request->get('yCoord');
        $level = $session->get("Level");
        $heavenlyKey = $session->get("heavenly_key") ?? false;
        $key = $session->get("key") ?? false;
        $check = $level->checkCoord($xCoord, $yCoord);

        $level->setPrompt($check);
        if ($check == "key" && $key == false) {
            $session->set("key", true);
            $level->setPrompt("You found a key!");
            $key = true;
        } elseif ($check == "heavenly_key" && $heavenlyKey == false) {
            $level->setPrompt("You found the Heavenly Portal Opener!");
            $session->set("heavenly_key", true);
            $heavenlyKey = true;
        } elseif ($check == "Hell") {
            $level = $level->next($key, $heavenlyKey, "Hell");
        } elseif ($check == "Restart") {
            $session->set("key", false);
            $session->set("heavenly_key", false);
            return $this->redirectToRoute('proj_score');
            // $level = $level->next();
        } elseif ($check != "Nothing happened") {
            $level = $level->next($key, $heavenlyKey);
        }

        $session->set("Level", $level);
        return $this->redirectToRoute('proj_play');
    }
    #endregion

    #region go back
    #[Route('/proj/back', name: 'proj_back', methods: ['POST'])]
    public function back(
        Session $session
    ): Response {
        $level = $session->get("Level");
        $level = $level->previous();
        $session->set("Level", $level);

        return $this->redirectToRoute('proj_play');
    }
    #endregion

    #region Form for Saving
    #[Route('/proj/score', name: 'proj_score')]
    public function score(
        Session $session,
        ManagerRegistry $doctrine,
        Request $request,
    ): Response {

        $ipAddress = $request->getClientIp();
        $ipLogger = new IPLogger();

        $level = $session->get("Level");
        $destination = "Elysium";
        $formClass = new Saved();
        $title = "What is your name, you beautiful beast?";

        if (get_class($level) == "App\Proj\HellSceneLevel") {
            $formClass = new Condemned();
            $title = "What is your name, condemned one?";
            $destination = "Hell";
        }

        $form = $this->createForm(ScoreForm::class, $formClass);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {

            return $this->render('proj/save.html.twig', [
                'save_form' => $form->createView(),
                "title" => $title]);
        }
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('Europe/Stockholm'));
        $formClass->setTime($now);
        $formClass->setName($form->get('Name')->getData());
        $level = $level->next();
        $session->set("Level", $level);

        $ipLogger->setDestination($destination);
        $ipLogger->setName($form->get('Name')->getData());
        $ipLogger->setIp($ipAddress);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($formClass);
        $entityManager->persist($ipLogger);
        $entityManager->flush();
        return $this->redirectToRoute('proj_home');
    }
}
