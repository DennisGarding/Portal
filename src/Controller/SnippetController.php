<?php

namespace App\Controller;

use App\Entity\Snippet;
use App\Repository\Exceptions\SnippetRepositoryException;
use App\Repository\SnippetRepository;
use App\Validator\AbstractValidator;
use App\Validator\SnippetValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SnippetController extends AbstractController
{
    public function __construct(
        private readonly SnippetValidator  $snippetValidator,
        private readonly SnippetRepository $snippetRepository,
    )
    {

    }

    #[Route('/call/snippet/load', name: 'call_snippet_load', methods: ['GET'])]
    public function loadSnippets(): JsonResponse
    {
        $snippets = $this->snippetRepository->findAll();

        return $this->json($snippets);
    }

    #[Route('/call/snippet/load/{id}', name: 'call_snippet_load_by_id', methods: ['GET'])]
    public function loadSnippet(string $id): JsonResponse
    {
        $snippet = $this->snippetRepository->find($id);
        if ($snippet instanceof Snippet === false) {
            return $this->json(
                ['error' => \sprintf('Snippet by ID "%s" not found', $id)],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json($snippet);
    }

    #[Route('/call/snippet/{method}', name: 'call_snippet_save', methods: ['POST'])]
    public function saveSnippet(string $method, Request $request): JsonResponse
    {
        $snippetDataArray = json_decode($request->getContent(), true);

        $validation = $this->snippetValidator->validate($snippetDataArray, $method);
        if ($validation !== null) {
            return $this->json(
                ['error' => $validation],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $snippet = match ($method) {
                AbstractValidator::METHOD_CREATE => $this->snippetRepository->create($snippetDataArray),
                AbstractValidator::METHOD_UPDATE => $this->snippetRepository->update($snippetDataArray),
                default => null,
            };
        } catch (SnippetRepositoryException $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->json($snippet);
    }

    #[Route('/call/snippet/delete/{id}', name: 'call_snippet_delete', methods: ['DELETE'])]
    public function deleteSnippet(string $id): JsonResponse
    {
        $snippet = $this->snippetRepository->find($id);

        if ($snippet instanceof Snippet === false) {
            return $this->json(
                ['error' => \sprintf('Snippet by ID "%s" not found', $id)],
                Response::HTTP_BAD_REQUEST
            );
        }

        $this->snippetRepository->delete($snippet);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
