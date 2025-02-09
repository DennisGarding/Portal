<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;

class CategoryValidator extends AbstractValidator
{
    protected function getCreateConstraints(): Assert\Collection
    {
        return new Assert\Collection($this->createBasicConstraints());
    }

    protected function getUpdateConstraints(): Assert\Collection
    {
        $constraints = $this->createBasicConstraints();
        $constraints['id'] = $this->createIdConstraints();

        return new Assert\Collection($constraints);
    }

    private function createBasicConstraints(): array
    {
        return [
            'name' => $this->createNameConstraints(),
            'type' => $this->createTypeConstraints(),
            'links' => [],
            'snippets' => [],
        ];
    }

    private function createTypeConstraints(): array
    {
        return [
            new Assert\NotBlank(null, 'Type is required.'),
            new Assert\Type('string', 'Type must be a non empty string.'),
            $this->createTypeOnOfConstraint()
        ];
    }

    private function createTypeOnOfConstraint(): Assert\AtLeastOneOf
    {
        $types = [
            'link',
            'snippet',
        ];

        $constraints = [];
        foreach ($types as $type) {
            $constraints[] = new Assert\IdenticalTo($type);
        }

        return new Assert\AtLeastOneOf([
            'constraints' => $constraints,
        ], null, null, \sprintf('Type must be one of "%s".', implode(', ', $types)));
    }
}