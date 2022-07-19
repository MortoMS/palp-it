<?php 

namespace App\Exceptions;

use Exception;
use Throwable;

class ValidationException extends Exception
{   
    private array $messageValition;

    public function __construct(
        array $message = [],
        $code = 0,
        Throwable $previous = null
    ) {
        $this->messageValition = $message;

        parent::__construct(
            "Custom Exception by ValidationException",
            $code,
            $previous
        );
    }

    public function getMessageValition(): array
    {
        return $this->messageValition;
    }
}
