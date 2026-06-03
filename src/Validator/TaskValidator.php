<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;

class TaskValidator extends AbstractValidator
{
    public const METHOD_MOVE = 'move';

    protected function getConstraints(string $method): Assert\Collection
    {
        if ($method === self::METHOD_MOVE) {
            return $this->getMoveConstraints();
        }

        return parent::getConstraints($method);
    }

    protected function getCreateConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'name' => $this->createNameConstraints(),
            'description' => new Assert\Type('string', 'Description must be a non empty string.'),
            'priority' => $this->createPrioritiesConstraints(),
            'dueDate' => $this->createDueDateConstraints(),
            'status' => $this->createStatusConstraints(),
        ]);
    }

    protected function getUpdateConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'id' => $this->createIdConstraints(),
            'name' => $this->createNameConstraints(),
            'description' => new Assert\Type('string', 'Description must be a non empty string.'),
            'priority' => $this->createPrioritiesConstraints(),
            'dueDate' => $this->createDueDateConstraints(),
            'status' => $this->createStatusConstraints(),
        ]);
    }

    private function createDueDateConstraints(): array
    {
        return [
            new Assert\Optional([
//                new Assert\DateTime(message: 'Due date must be a valid date time string.')
            ])
        ];
    }

    private function getMoveConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'targetStatus' => $this->createStatusConstraints(),
        ]);
    }

    private function createPrioritiesConstraints(): array
    {
        $priorities = [
            'low',
            'mid',
            'high',
        ];

        $constraints = [];
        foreach ($priorities as $priority) {
            $constraints[] = new Assert\IdenticalTo($priority);
        }

        return [
            new Assert\NotBlank(['message' => 'Priority must be a non empty string.']),
            new Assert\AtLeastOneOf([
                'constraints' => $constraints,
            ], null, null, \sprintf('Priority must be one of "%s".', implode(', ', $priorities)))
        ];
    }

    private function createStatusConstraints(): array
    {
        $status = [
            'open',
            'inProgress',
            'inReview',
            'completed',
        ];

        $constraints = [];
        foreach ($status as $state) {
            $constraints[] = new Assert\IdenticalTo($state);
        }

        return [
            new Assert\NotBlank(['message' => 'Status must be a non empty string.']),
            new Assert\AtLeastOneOf([
                'constraints' => $constraints,
            ], null, null, \sprintf('Status must be one of "%s".', implode(', ', $status)))
        ];
    }
}