<?php

declare(strict_types=1);

namespace Domain\Integrations\RabbitMQ\Interfaces;

interface ConsumerInterface
{
    public function basicConsume(string $queue, string $consumerTag);
}
