<?php

declare(strict_types=1);

namespace Domain\Integrations\RabbitMQ;

use Domain\Integrations\RabbitMQ\Interfaces\PublisherInterface;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Message\AMQPMessage;

class Publisher extends RabbitMQ implements PublisherInterface
{
    public function __construct()
    {
        parent::__construct();
        Log::debug('RabbitMQ Publisher started');
    }

    public function basicPublish(string $message, string $exchange, string $routingKey)
    {
        $properties = ['content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT];
        $amqpMessage = new AMQPMessage($message, $properties);

        $this->channel->basic_publish($amqpMessage, $exchange, $routingKey);
        Log::debug('Message published to RabbitMQ');

        return $this;
    }
}
