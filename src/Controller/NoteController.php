<?php

namespace App\Controller;

use App\Entity\Note;
use App\Repository\Exceptions\NoteRepositoryException;
use App\Repository\NoteRepository;
use App\Validator\AbstractValidator;
use App\Validator\NoteValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NoteController extends AbstractController
{
    public function __construct(
        private readonly NoteValidator $noteValidator,
        private readonly NoteRepository $noteRepository
    ) {}

    #[Route('/call/note/load/{noteId}', name: 'call_note_load', methods: ['GET'])]
    public function loadNote(string $noteId): JsonResponse
    {
        $note = $this->noteRepository->find($noteId);
        if ($note instanceof Note === false) {
            return $this->json(
                ['error' => 'Note not found'],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json($note);
    }

    #[Route('/call/note/delete/{noteId}', name: 'call_note_delete', methods: ['DELETE'])]
    public function delete(string $noteId): JsonResponse
    {
        $note = $this->noteRepository->find($noteId);
        if ($note instanceof Note === false) {
            return $this->json(
                ['error' => 'Note not found'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $this->noteRepository->delete($note);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/call/note/{method}', name: 'call_note_create_update', methods: ['POST'])]
    public function note(string $method, Request $request): JsonResponse
    {
        $noteDataArray = json_decode($request->getContent(), true);

        $validation = $this->noteValidator->validate($noteDataArray, $method);
        if ($validation !== null) {
            return $this->json(
                ['error' => $validation],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $note = match ($method) {
                AbstractValidator::METHOD_CREATE => $this->noteRepository->create($noteDataArray),
                AbstractValidator::METHOD_UPDATE => $this->noteRepository->update($noteDataArray),
                default => null,
            };
        } catch (NoteRepositoryException $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->json($note);
    }
}