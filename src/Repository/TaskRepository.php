<?php

namespace App\Repository;

use App\Entity\Task;
use App\Repository\Exceptions\TaskRepositoryException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function create(array $taskData): Task
    {
        $task = new Task();
        $task->setName($taskData['name']);
        $task->setDescription($taskData['description']);
        $task->setPriority($taskData['priority']);
        $task->setStatus($taskData['status']);
        $task->setDueDate($this->convertDateTime($taskData['dueDate'] ?? null));

        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();

        return $task;
    }

    public function update(array $taskData): Task
    {
        $task = $this->find($taskData['id']);
        if (!$task instanceof Task) {
            throw new TaskRepositoryException('Task not found');
        }

        $task->setName($taskData['name']);
        $task->setDescription($taskData['description']);
        $task->setPriority($taskData['priority']);
        $task->setStatus($taskData['status']);
        $task->setDueDate($this->convertDateTime($taskData['dueDate'] ?? null));

        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();

        return $task;
    }

    public function move(Task $task): Task
    {
        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();

        return $task;
    }

    public function delete(Task $task): void
    {
        $this->getEntityManager()->remove($task);
        $this->getEntityManager()->flush();
    }

    private function convertDateTime(?string $dateTime): ?\DateTime
    {
        if ($dateTime === null) {
            return null;
        }

        return new \DateTime(\date("Y-m-d H:i:s", \strtotime($dateTime)));

    }
}
