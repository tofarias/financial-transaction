<?php

declare(strict_types=1);

namespace Domain\Notification\V1;

use Domain\Transaction\V1\Models\Transaction;

class NotificationService
{
    public function __construct(private NotificationPublisher $publisher)
    {
    }

    public function notify(Transaction $transaction)
    {
        $this->publisher->sendNotification($transaction);
    }
}
