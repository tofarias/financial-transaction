<?php

declare(strict_types=1);

return [
    'host' => env('RABBITMQ_HOST', 'rabbitmq'),
    'port' => env('RABBITMQ_PORT', 5672),
    'user' => env('RABBITMQ_USER', 'guest'),
    'password' => env('RABBITMQ_PASSWORD', 'guest'),
    'vhost' => env('RABBITMQ_VHOST', '/'),
    'transaction' => [
        'queue' => 'TransactionCreatedQueue',
        'exchange' => 'TransactionEx',
        'bind' => 'TransactionCreatedQueue',
        'routing_key' => 'transaction_created_route',
    ],
];
