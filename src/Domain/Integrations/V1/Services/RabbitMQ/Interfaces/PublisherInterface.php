<?php

declare(strict_types=1);

namespace Domain\Integrations\V1\Services\RabbitMQ\Interfaces;

interface PublisherInterface
{
    public function basicPublish(string $message, string $exchange, string $routingKey);

    public function setQueue(string $queue);

    public function setExchange(string $exchange);

    public function setBind(string $queue, string $exchange, string $routingKey);
}
