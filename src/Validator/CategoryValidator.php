<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;

class CategoryValidator extends AbstractValidator
{
    protected function getCreateConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'name' => $this->createNameConstraints(),
            'type' => $this->createTypeConstraints(),
        ]);
    }

    protected function getUpdateConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'id' => $this->createIdConstraints(),
            'name' => $this->createNameConstraints(),
            'type' => $this->createTypeConstraints(),
        ]);
    }

    private function createTypeConstraints()
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