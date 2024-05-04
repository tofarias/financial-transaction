<?php

declare(strict_types=1);

namespace Domain\Integrations\Authorization\Exceptions;

use DomainException;
use Exception;

class UnauthorizedTransactionException extends DomainException
{
    public function __construct(string $message = '', int $code = 422, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
