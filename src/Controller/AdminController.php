<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    #[Route('/{route}', name: 'app_vue_pages', requirements: ['route' => '^(?!login|register|logout|call.+).+'])]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/call/keepAlive', name: 'call_keep_alive', methods: ['GET'])]
    public function isLoggedIn(UserInterface $user): JsonResponse
    {
        if ($user->getUserIdentifier()) {
            return $this->json(['success' => true]);
        }

        return $this->json(['success' => false], Response::HTTP_UNAUTHORIZED);
    }

    #[Route('/call/load/user', name: 'call_load_user', methods: ['GET'])]
    public function loadUser(UserInterface $user): JsonResponse
    {
        if ($user->getUserIdentifier()) {
            return $this->json(['userMail' => $user->getUserIdentifier()]);
        }

        return $this->json(['error' => 'User not found.'], Response::HTTP_UNAUTHORIZED);
    }
}
