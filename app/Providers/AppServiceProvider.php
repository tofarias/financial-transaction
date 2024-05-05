<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Domain\Integrations\RabbitMQ\Consumer;
use Domain\Integrations\RabbitMQ\Publisher;
use Domain\Notification\V1\NotificationConsumer;
use Illuminate\Http\Resources\Json\JsonResource;
use Domain\Notification\V1\NotificationPublisher;

use Domain\Transaction\V1\Infra\{TransactionCommand, TransactionQuery};
use Domain\Transaction\V1\Infra\Interfaces\
{TransactionCommand as TransactionCommandInterface, TransactionQuery as TransactionQueryInterface};

class AppServiceProvider extends ServiceProvider
{
    /** Register any application services. */
    public function register(): void
    {
        $this->app->singleton(\Faker\Generator::class, function () {
            return \Faker\Factory::create('pt_BR');
        });

        $this->bindNotifications();
        $this->bindTransactions();
    }

    /** Bootstrap any application services. */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        Model::shouldBeStrict( ! $this->app->environment('production'));
    }

    public function bindTransactions(): void
    {
        $this->app->bind(TransactionCommandInterface::class, function ($app) {
            return new TransactionCommand();
        });

        $this->app->bind(TransactionQueryInterface::class, function ($app) {
            return new TransactionQuery();
        });
    }

    public function bindNotifications(): void
    {
        $this->app->bind(NotificationPublisher::class, function ($app) {
            return new NotificationPublisher(new Publisher());
        });

        $this->app->bind(NotificationConsumer::class, function ($app) {
            return new NotificationConsumer(new Consumer());
        });
    }
}
