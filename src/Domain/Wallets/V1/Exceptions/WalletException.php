<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Exceptions;

use Exception;

class WalletException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
