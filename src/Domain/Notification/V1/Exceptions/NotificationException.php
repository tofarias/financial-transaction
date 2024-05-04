<?php

declare(strict_types=1);

namespace Domain\Notification\V1\Exceptions;

use Exception;

class NotificationException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
