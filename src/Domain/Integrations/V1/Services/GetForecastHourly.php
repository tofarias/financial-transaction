<?php

declare(strict_types=1);

namespace Domain\Integrations\V1\Services;

use ArgumentCountError;
use Illuminate\Support\Facades\Cache;
use Domain\Shared\Services\BaseServiceExecute;
use Domain\Integrations\V1\Api\ATFarm\ATFarmService;
use Domain\Integrations\V1\Api\ATFarm\Enums\CacheEnum;

class GetForecastHourly extends BaseServiceExecute
{
    /**
     * A description of the entire PHP function.
     *
     * @return mixed
     */
    public function execute(): mixed
    {
        $validData = $this->dto->valid_data;

        $this->validate();

        return Cache::remember(
            $this->createCacheName(),
            config('atfarm.cache_ttl'),
            function () use ($validData) {
                return app(ATFarmService::class)
                    ->getForecastHourly(
                        $validData->latitude,
                        $validData->longitude,
                        $validData->days_limit
                    )->json();
            }
        );
    }

    private function createCacheName(): string
    {
        return CacheEnum::FORECAST_HOURLY->value.$this->dto->valid_data->city;
    }

    protected function validate(): void
    {
        $this->unless($this->dto->valid_data->city, function () {
            throw new ArgumentCountError('city is required and not empty');
        });

        $this->unless($this->dto->valid_data->latitude, function () {
            throw new ArgumentCountError('latitude is required and not empty');
        });

        $this->unless($this->dto->valid_data->longitude, function () {
            throw new ArgumentCountError('longitude is required and not empty');
        });

        $this->unless($this->dto->valid_data->days_limit, function () {
            throw new ArgumentCountError('days_limit is required and not empty');
        });
    }
}
