<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Saved;
use App\Entity\Condemned;
use App\Repository\IPLoggerRepository;
use App\Repository\SavedRepository;
use App\Repository\CondemnedRepository;
use Doctrine\Persistence\ManagerRegistry;

use DateTime;
use DateTimeZone;

class APIProjController extends AbstractController
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    #[Route('/proj/api/condemned', name:"api_proj_condemned_all")]
    public function apiCondemnedAll(
        CondemnedRepository $condemnedRepository
    ): Response {
        $condemned = $condemnedRepository
            ->findAll();

        // $response = new Response();
        // $response->setContent(json_encode($books));
        $response = $this->json($condemned);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route('/proj/api/saved', name:"api_proj_saved_all")]
    public function apiSavedAll(
        SavedRepository $savedRepository
    ): Response {
        $saved = $savedRepository
            ->findAll();

        // $response = new Response();
        // $response->setContent(json_encode($books));
        $response = $this->json($saved);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    
    #[Route('/proj/api/logged', name:"api_proj_logged")]
    public function apiLoggedAll(
        IPLoggerRepository $IPLoggerRepository
    ): Response {
        $ipEntries = $IPLoggerRepository
            ->findAll();

        // $response = new Response();
        // $response->setContent(json_encode($books));
        $response = $this->json($ipEntries);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route('/proj/api', name:"api_proj_home")]
    public function apiHome(): Response {


        return $this->render('proj/api.html.twig');
    }

    #[Route('/proj/api/save_all', name:"api_proj_save_all", methods: ['POST'])]
    public function apiSaveAll(
        SavedRepository $savedRepository,
        CondemnedRepository $condemnedRepository,
        ManagerRegistry $doctrine,
    ): Response {
        $condemned = $condemnedRepository
            ->findAll();

        $entityManager = $doctrine->getManager();
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('Europe/Stockholm'));

        foreach($condemned as $exCon) {
            $saved = new Saved();
            $saved->setName($exCon->getName());
            $saved->setTime($now);

            $entityManager->persist($saved);
            $entityManager->flush();

            $entityManager->remove($exCon);
            $entityManager->flush();
        }
        return $this->redirectToRoute('api_proj_saved_all');
    }

    

    #[Route('/proj/api/get_status', name:"api_status")]
    public function apiStatus(
        SavedRepository $savedRepository,
        CondemnedRepository $condemnedRepository,
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {

        $key = false;
        if ($session->has('key')) {
            $key = $session->get("key");
        }

        $heavenlyKey = false;
        if ($session->has('heavenly_key')) {
            $heavenlyKey = $session->get("heavenly_key");
        }

        $level = "None";
        if ($session->has('Level')) {
            $temp = get_class($session->get("Level"));
            $parts = explode("\\", $temp);
            $level = end($parts);
        }

        $response = new Response();
        $data = ["level" => $level,
                "has_key" => $key,
                "has_heavenly_key" => $heavenlyKey];

        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;

    }

    #[Route('/proj/api/reset_game_tables', name:"api_proj_reset_tables")]
    public function apiReset(
        SavedRepository $savedRepository,
        CondemnedRepository $condemnedRepository,
        IPLoggerRepository $IPLoggerRepository,
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {

        $condemned = $condemnedRepository->findAll();
        $saved = $savedRepository->findAll();
        $ipEntries = $IPLoggerRepository->findAll();
        $entityManager = $doctrine->getManager();
        //Delete All
        foreach($condemned as $exCon) {
            $entityManager->remove($exCon);
        }
        $entityManager->flush();

        foreach($saved as $happy) {
            $entityManager->remove($happy);
        }

        foreach($ipEntries as $ipAdd) {
            $entityManager->remove($ipAdd);
        }
        $entityManager->flush();


        $em = $doctrine->getManager();
        $connection = $em->getConnection();/* @phpstan-ignore-line */

        $sqlSaved = "
            INSERT INTO saved VALUES
            (1, 'Herman', '2024-05-18 16:41:09'),
            (2, 'Owe', '2024-05-18 17:23:03'),
            (3, 'Gurkan', '2024-05-19 09:40:15'),
            (4, 'Kenneth', '2024-05-19 11:47:22');";
        $stmt = $connection->prepare($sqlSaved);
        $stmt->executeStatement();

        $sqlCond = "
            INSERT INTO condemned VALUES
            (1, 'Faust', '2024-01-01 16:41:09'),
            (2, 'Dante', '2024-02-01 17:41:03'),
            (3, 'Samael', '2024-03-01 09:41:15'),
            (4, 'Beast', '2024-04-01 11:41:22');";
        $stmt = $connection->prepare($sqlCond);
        $stmt->executeStatement();

        $sqlIp = "
        INSERT INTO iplogger VALUES
        (1, 'Faust', 'Hell', '666.666.666.1'),
        (2, 'Dante', 'Hell', '666.666.666.1'),
        (3, 'Samael', 'Hell', '666.666.666.1'),
        (4, 'Beast', 'Hell', '666.666.666.1'),
        (5, 'Herman', 'Elysium', '127.0.0.1'),
        (6, 'Owe', 'Elysium', '127.0.0.1'),
        (7, 'Gurkan', 'Elysium', '127.0.0.1'),
        (8, 'Kenneth', 'Elysium', '127.0.0.1');";
        $stmt = $connection->prepare($sqlIp);
        $stmt->executeStatement();

        return $this->redirectToRoute('api_proj_home');
    }





}
