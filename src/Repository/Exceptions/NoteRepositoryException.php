<?php

namespace App\Repository\Exceptions;

class NoteRepositoryException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}