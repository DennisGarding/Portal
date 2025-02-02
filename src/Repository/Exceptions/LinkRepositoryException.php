<?php

namespace App\Repository\Exceptions;

class LinkRepositoryException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}