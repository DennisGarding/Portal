<?php

namespace App\Controller;

use App\Entity\Link;
use App\Repository\Exceptions\LinkRepositoryException;
use App\Repository\LinkRepository;
use App\Validator\AbstractValidator;
use App\Validator\LinkValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LinkController extends AbstractController
{
    public function __construct(
        private readonly LinkValidator $linkValidator,
        private readonly LinkRepository $linkRepository
    ) {}

    #[Route('/call/link/load/{linkId}', name: 'api_link_load', methods: ['GET'])]
    public function loadLink(string $linkId): JsonResponse
    {
        $link = $this->linkRepository->find($linkId);
        if ($link instanceof Link === false) {
            return $this->json(
                ['error' => 'Link not found'],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json($link);
    }

    #[Route('/call/link/delete/{linkId}', name: 'api_link_delete', methods: ['DELETE'])]
    public function delete(string $linkId): JsonResponse
    {
        $link = $this->linkRepository->find($linkId);
        if ($link instanceof Link === false) {
            return $this->json(
                ['error' => 'Link not found'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $this->linkRepository->delete($link);

        return $this->json([]);
    }

    #[Route('/call/link/{method}', name: 'api_link_create_update_move', methods: ['POST'])]
    public function link(string $method, Request $request): JsonResponse
    {
        $linkDataArray = json_decode($request->getContent(), true);

        $validation = $this->linkValidator->validate($linkDataArray, $method);
        if ($validation !== null) {
            return $this->json(
                ['error' => $validation],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $link = match ($method) {
                AbstractValidator::METHOD_CREATE => $this->linkRepository->create($linkDataArray),
                AbstractValidator::METHOD_UPDATE => $this->linkRepository->update($linkDataArray),
                LinkValidator::METHOD_MOVE => $this->linkRepository->move($linkDataArray),
                default => null,
            };
        } catch (LinkRepositoryException $e) {
            return $this->json(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->json($link);
    }
}