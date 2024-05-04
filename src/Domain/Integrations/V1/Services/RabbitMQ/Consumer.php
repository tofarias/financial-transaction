<?php

declare(strict_types=1);

namespace Domain\Integrations\V1\Services\RabbitMQ;

use Illuminate\Support\Facades\Log;
use Domain\Integrations\V1\Services\RabbitMQ\Interfaces\ConsumerInterface;

class Consumer extends RabbitMQ implements ConsumerInterface
{
    public function __construct()
    {
        parent::__construct();
        Log::debug('RabbitMQ Consumer started');
    }

    public function basicConsume(string $queue, string $consumerTag)
    {
        $this->channel->basic_consume(
            $queue,
            $consumerTag,
            false,
            true,
            false,
            false,
            function ($message) {
                echo "\n--------\n";
                echo $message->body;
                echo "\n--------\n";

                $message->ack();

                if ($message->body === 'quit') {
                    $message->getChannel()->basic_cancel($message->getConsumerTag());
                }
                Log::debug('Message consumed: ' . $message->body);
            }
        );
        // $this->channel->consume();
        Log::debug('Message consumed on RabbitMQ');

        return $this;
    }
}
