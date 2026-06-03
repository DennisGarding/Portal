<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;

class NoteValidator extends AbstractValidator
{
    protected function getCreateConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'name' => $this->createNameConstraints(),
            'note' => $this->createNoteConstraints(),
            'categoryId' => $this->createCategoryIdConstraints(),
        ]);
    }

    protected function getUpdateConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'id' => $this->createIdConstraints(),
            'name' => $this->createNameConstraints(),
            'note' => $this->createNoteConstraints(),
            'categoryId' => $this->createCategoryIdConstraints(),
        ]);
    }

    private function createNoteConstraints(): array
    {
        return [
            new Assert\NotBlank(null, 'Note is required.'),
            new Assert\Type('string', 'Note must be a non empty string.'),
        ];
    }
}