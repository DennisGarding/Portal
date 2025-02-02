<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;

class LinkValidator extends AbstractValidator
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
            'url' => $this->createUrlConstraints(),
            'categoryId' => $this->createCategoryIdConstraints(),
        ]);
    }

    protected function getUpdateConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'id' => $this->creatIdConstraints(),
            'name' => $this->createNameConstraints(),
            'url' => $this->createUrlConstraints(),
            'categoryId' => $this->createCategoryIdConstraints(),
        ]);
    }

    protected function getMoveConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'id' => $this->creatIdConstraints(),
            'categoryId' => $this->createCategoryIdConstraints(),
        ]);
    }

    private function createNameConstraints(): array
    {
        return [
            new Assert\NotBlank(null, 'Name is required.'),
            new Assert\Type('string', 'Name must be a non empty string.'),
            new Assert\Length(
                ['min' => 1, 'max' => 255],
                null,
                null,
                null,
                null,
                null,
                null,
                'Name must be between 1 and 255 characters long.',
                'Name must be between 1 and 255 characters long.'
            ),
        ];
    }

    private function createUrlConstraints(): array
    {
        return [
            new Assert\NotBlank(null, 'URL is required.'),
            new Assert\Type('string', 'URL must be a non empty string.'),
            new Assert\Url(null, 'URL must be a valid URL.'),
        ];
    }

    private function createCategoryIdConstraints(): array
    {
        return [
            new Assert\NotBlank(null, 'Category ID is required.'),
            new Assert\Type('number', 'Category ID must be an integer.'),
        ];
    }
}