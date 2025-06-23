<?php
declare(strict_types=1);

namespace Src\Exceptions;

use Exception;

class AppException extends Exception
{
    private array $context = [];

    public function __construct($message, $code = 0, $context = [], $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    public function getContext(): array {
        return $this->context;
    }
}