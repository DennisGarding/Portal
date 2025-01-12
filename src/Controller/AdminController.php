<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    #[Route('/{route}', name: 'app_vue_pages', requirements: ['route' => '^(?!login|register|logout|api.+).+'])]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
