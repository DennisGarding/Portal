<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;

class SnippetValidator extends AbstractValidator
{
    protected function getCreateConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'name' => $this->createNameConstraints(),
            'description' => new Assert\Type('string', 'Description must be a non empty string.'),
            'code' => $this->createCodeConstraints(),
            'type' => $this->createTypeConstraints(),
            'categoryId' => $this->createCategoryIdConstraints(),
        ]);
    }

    protected function getUpdateConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'id' => $this->createIdConstraints(),
            'name' => $this->createNameConstraints(),
            'description' => new Assert\Type('string', 'Description must be a non empty string.'),
            'code' => $this->createCodeConstraints(),
            'type' => $this->createTypeConstraints(),
            'categoryId' => $this->createCategoryIdConstraints(),
        ]);
    }

    private function createCodeConstraints(): array
    {
        return [
            new Assert\NotBlank(null, 'Code is required.'),
            new Assert\Type('string', 'Code must be a non empty string.'),
        ];
    }

    private function createTypeConstraints(): array
    {
        return [
            new Assert\NotBlank(null, 'Type is required.'),
            new Assert\Type('string', 'Type must be a non empty string.'),
            $this->createTypeOnOfConstraint(),
        ];
    }

    private function createTypeOnOfConstraint(): Assert\AtLeastOneOf
    {
        $types = [
            'php',
            'sql',
            'javascript',
            'typescript',
            'html',
            'twig',
            'css',
            'less',
            'scss',
            'yaml',
            'json',
            'other',
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