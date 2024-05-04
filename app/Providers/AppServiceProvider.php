<?php

declare(strict_types=1);

namespace App\Providers;

use Domain\Integrations\V1\Services\RabbitMQ\Publisher;
use Domain\Notification\V1\NotificationPublisher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /** Register any application services. */
    public function register(): void
    {
        $this->app->singleton(\Faker\Generator::class, function () {
            return \Faker\Factory::create('pt_BR');
        });

        $this->app->bind(NotificationPublisher::class, function ($app) {
            return new NotificationPublisher(new Publisher());
        });
    }

    /** Bootstrap any application services. */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        Model::shouldBeStrict( ! $this->app->environment('production'));
    }
}
