<?php

namespace App\Controller;

use App\Entity\JSDateConverter;
use App\Entity\Task;
use App\Repository\Exceptions\TaskRepositoryException;
use App\Repository\TaskRepository;
use App\Validator\AbstractValidator;
use App\Validator\TaskValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    public function __construct(
        private readonly TaskValidator  $taskValidator,
        private readonly TaskRepository $taskRepository
    )
    {
    }

    #[Route('/call/task/load/{taskId}', name: 'call_task_load', methods: ['GET'])]
    public function loadTask(string $taskId): JsonResponse
    {
        $task = $this->taskRepository->find($taskId);
        if ($task instanceof Task === false) {
            return $this->json(
                ['error' => 'Task not found'],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json($task);
    }

    #[Route('/call/task/load', name: 'call_task_load_all', methods: ['GET'])]
    public function loadTasks()
    {
        $taskList = $this->taskRepository->findAll();

        return $this->json($taskList);
    }

    #[Route('/call/task/delete/{taskId}', name: 'call_task_delete', methods: ['DELETE'])]
    public function delete(string $taskId): JsonResponse
    {
        $task = $this->taskRepository->find($taskId);
        if ($task instanceof Task === false) {
            return $this->json(
                ['error' => 'Task not found'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $this->taskRepository->delete($task);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/call/task/{method}', name: 'call_task_create_update', methods: ['POST'])]
    public function task(string $method, Request $request): JsonResponse
    {
        $taskDataArray = json_decode($request->getContent(), true);

        $validation = $this->taskValidator->validate($taskDataArray, $method);
        if ($validation !== null) {
            return $this->json(
                ['error' => $validation],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $task = match ($method) {
                AbstractValidator::METHOD_CREATE => $this->taskRepository->create($taskDataArray),
                AbstractValidator::METHOD_UPDATE => $this->taskRepository->update($taskDataArray),
                default => null,
            };
        } catch (TaskRepositoryException $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->json($task);
    }

    #[Route('/call/task/move/{taskId}', name: 'call_task_move', methods: ['POST'])]
    public function move(string $taskId, Request $request): JsonResponse
    {
        $taskDataArray = json_decode($request->getContent(), true);
        $validation = $this->taskValidator->validate($taskDataArray, 'move');
        if ($validation !== null) {
            return $this->json(
                ['error' => $validation],
                Response::HTTP_BAD_REQUEST
            );
        }

        $task = $this->taskRepository->find($taskId);
        if (!$task instanceof Task) {
            return $this->json(
                ['error' => \sprintf('Task with id %s not found', $taskId)],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $task->setStatus($taskDataArray['targetStatus'] ?? 'open');

        $this->taskRepository->move($task);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
