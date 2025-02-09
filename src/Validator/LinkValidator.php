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
            'id' => $this->createIdConstraints(),
            'name' => $this->createNameConstraints(),
            'url' => $this->createUrlConstraints(),
            'categoryId' => $this->createCategoryIdConstraints(),
        ]);
    }

    protected function getMoveConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'id' => $this->createIdConstraints(),
            'categoryId' => $this->createCategoryIdConstraints(),
        ]);
    }

    private function createUrlConstraints(): array
    {
        return [
            new Assert\NotBlank(null, 'URL is required.'),
            new Assert\Type('string', 'URL must be a non empty string.'),
            new Assert\Url(null, 'URL must be a valid URL.'),
        ];
    }
}