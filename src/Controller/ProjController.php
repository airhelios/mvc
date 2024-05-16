<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    public function home(): Response
    {
        return $this->render('proj/about.html.twig');
    }
    #endregion
}
