<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
* @SuppressWarnings(PHPMD.Superglobals)
*/
class BaseController extends AbstractController
{
    public function __construct()
    {
        session_start();
    }
    #[Route('/', name: "home")]
    public function meStart(): Response
    {
        return $this->render('me.html.twig');
    }

    #[Route('/metrics', name: "metrics")]
    public function metrics(): Response
    {
        return $this->render('metrics.html.twig');
    }

    #[Route('/about', name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route('/report', name:"report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route('/session', name: "session")]
    public function session(SessionInterface $session): Response
    {
        $data = [
            "session" => $session,
            "SESSION_GLOBAL" => $_SESSION,
        ];


        return $this->render('session/session.html.twig', $data);
    }

    #[Route('/session/delete', name: "session_delete")]
    public function sessionDelete(SessionInterface $session): Response
    {
        $this->addFlash(
            'warning',
            'Absolutely murdering the session'
        );


        $_SESSION = [];

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        // Finally, destroy the session.
        session_destroy();
        $session->clear(); //This is from symfony


        $data = [
            "session" => $session,
            "SESSION_GLOBAL" => $_SESSION,
        ];
        return $this->render('session/session.html.twig', $data);
    }
}
