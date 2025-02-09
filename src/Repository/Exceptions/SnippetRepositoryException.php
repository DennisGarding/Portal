<?php

namespace App\Repository\Exceptions;

class SnippetRepositoryException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}