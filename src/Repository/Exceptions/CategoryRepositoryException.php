<?php

namespace App\Repository\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class CategoryRepositoryException extends \Exception
{
    public function __construct(string $message, int $code = Response::HTTP_INTERNAL_SERVER_ERROR, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}