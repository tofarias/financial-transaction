<?php

declare(strict_types=1);

namespace Domain\Integrations\V1\Services\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;

class Publisher extends RabbitMQ
{
    public function __construct(string $message, array $properties = [])
    {
        if(empty($properties)) {
            $properties = ['content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT];
        }

        $this->amqpMessage = new AMQPMessage($message, $properties);
        parent::__construct();
    }

    public function publish(string $exchange, string $routingKey)
    {
        $this->channel->basic_publish($this->amqpMessage, $exchange, $routingKey);
    }
}