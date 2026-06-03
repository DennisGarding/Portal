<?php

namespace App\Repository\Exceptions;

class TaskRepositoryException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}