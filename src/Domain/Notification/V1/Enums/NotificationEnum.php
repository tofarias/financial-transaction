<?php

declare(strict_types=1);

namespace Domain\Notification\V1\Enums;

enum NotificationEnum: string
{
    case NOTIFICATION_RECEIVED = '1';

    public function isReceived(): bool
    {
        return $this === self::NOTIFICATION_RECEIVED;
    }
}
