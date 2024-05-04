<?php

declare(strict_types=1);

namespace Domain\Integrations\V1\Services\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Connection\AMQPStreamConnection;

abstract class RabbitMQ
{
    protected AMQPStreamConnection $conn;
    protected AMQPChannel $channel;
    protected AMQPMessage $amqpMessage;

    public function __construct()
    {
        $this->conn = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password'),
            config('rabbitmq.vhost')
        );
        $this->channel = $this->conn->channel();
    }

    public function setQueue(string $queue)
    {
        $this->channel->queue_declare($queue, false, true, false, false);
        return $this;
    }

    public function setExchange(string $exchange)
    {
        $this->channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);
        return $this;
    }

    public function setBind(string $queue, string $exchange)
    {
        $this->channel->queue_bind($queue, $exchange);
        return $this;
    }

    public function close()
    {
        $this->channel->close();
        $this->conn->close();
    }
}
