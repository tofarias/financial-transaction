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
            ->setQueue(config('rabbitmq.transaction.queue'))
            ->setExchange(config('rabbitmq.transaction.exchange'))
            ->setBind(config('rabbitmq.transaction.queue'), config('rabbitmq.transaction.exchange'), config('rabbitmq.transaction.routing_key'))
            ->basicPublish($message, config('rabbitmq.transaction.exchange'), config('rabbitmq.transaction.routing_key'))
            ->close();
    }
}
