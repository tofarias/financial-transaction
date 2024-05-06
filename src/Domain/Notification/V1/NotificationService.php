<?php

declare(strict_types=1);

namespace Domain\Notification\V1;

use Domain\Notification\V1\Interfaces\NotificationService as NotificationServiceInterface;
use Domain\Transaction\V1\Models\Transaction;

class NotificationService implements NotificationServiceInterface
{
    public function __construct(private NotificationPublisher $publisher)
    {
    }

    public function notify(Transaction $transaction)
    {
        $this->publisher->sendNotification($transaction);
    }
}
