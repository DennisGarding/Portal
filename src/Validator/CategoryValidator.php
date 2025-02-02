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
            'id' => $this->creatIdConstraints(),
            'name' => $this->createNameConstraints(),
            'type' => $this->createTypeConstraints(),
        ]);
    }

    private function createNameConstraints()
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

    private function createTypeConstraints()
    {
        return [
            new Assert\NotBlank(null, 'Type is required.'),
            new Assert\Type('string', 'Type must be a non empty string.'),
            new Assert\AtLeastOneOf([
                'constraints' => [
                    new Assert\IdenticalTo('link'),
                ],
            ], null, null, 'Type must be one of "link".'),
        ];
    }
}