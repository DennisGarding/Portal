<?php

namespace App\Validator;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractValidator
{
    public const METHOD_CREATE = 'create';

    public const METHOD_UPDATE = 'update';

    public const METHOD_DELETE = 'delete';

    public function validate(array|int|string $data, string $method): array|null
    {
        $violationMessages = [];
        $hasViolations = false;

        $constraints = $this->getConstraints($method);
        $violations = Validation::createValidator()->validate($data, $constraints);

        if ($violations->count() > 0) {
            foreach ($violations as $violation) {
                $hasViolations = true;
                $violationMessages[] = $violation->getPropertyPath() . ' ' . $violation->getMessage();
            }
        }

        if ($hasViolations) {
            return $violationMessages;
        }

        return null;
    }

    protected function getConstraints(string $method): Assert\Collection
    {
        return match ($method) {
            self::METHOD_CREATE => $this->getCreateConstraints(),
            self::METHOD_UPDATE => $this->getUpdateConstraints(),
            self::METHOD_DELETE => $this->getDeleteConstraints(),
            default => throw new \InvalidArgumentException('Invalid validator method provided. Got: ' . $method),
        };
    }

    protected function getDeleteConstraints(): Assert\Collection
    {
        return new Assert\Collection($this->creatIdConstraints());
    }

    protected function creatIdConstraints(): array
    {
        return [
            new Assert\NotBlank(null, 'ID is required.'),
            new Assert\Type('number', 'ID must be an number.'),
        ];
    }

    abstract protected function getCreateConstraints(): Assert\Collection;

    abstract protected function getUpdateConstraints(): Assert\Collection;
}