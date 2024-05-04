<?php

declare(strict_types=1);

namespace Domain\Notification\V1;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Traits\Conditionable;
use Domain\Notification\V1\Enums\NotificationEnum;
use Domain\Notification\V1\Exceptions\NotificationException;
use Domain\Integrations\V1\Services\RabbitMQ\Interfaces\ConsumerInterface;

class NotificationConsumer
{
    use Conditionable;

    protected PendingRequest $api;

    public function __construct(private ConsumerInterface $consumer)
    {
        $this->api = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->baseUrl(config('notification.base_url'));
    }

    public function receiveNotification(): void
    {
        try {
            Log::info('notifying notification...');
            $response = $this->api
                ->get(config('notification.endpoints.get_notification'))
                ->throw();

            if((string) $response->json('message') !== NotificationEnum::NOTIFICATION_RECEIVED->value) {
                throw new NotificationException('Error notifying transaction ');
            }
            $this->consumer->basicConsume(config('rabbitmq.transaction.queue'), config('rabbitmq.transaction.queue'));
        } catch (RequestException $th) {
            throw $th;
        }
        Log::info('notification has been sent');
    }
}
