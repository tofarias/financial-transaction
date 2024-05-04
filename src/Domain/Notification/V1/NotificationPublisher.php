<?php

declare(strict_types=1);

namespace Domain\Notification\V1;

use Domain\Transaction\V1\Models\Transaction;
use Domain\Integrations\V1\Services\RabbitMQ\Publisher;

class NotificationPublisher
{
    public function __construct(private Publisher $publisher)
    {
    }

    public function sendNotification(Transaction $transaction)
    {
        $message = $transaction->toJson();

        $this->publisher
            ->setQueue('TransactionCreatedQueue')
            ->setExchange('TransactionEx')
            ->setBind('TransactionCreatedQueue', 'TransactionEx', 'transaction_created_route')
            ->basicPublish($message, 'TransactionEx', 'transaction_created_route')
            ->close();
    }
}
