<?php

declare(strict_types=1);

namespace Domain\Integrations\V1\Http\Resources\ATFarm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForecastHourlyResource extends JsonResource
{
    /** Transform the resource into an array. */
    public function toArray(Request $request): array
    {
        return [
            /** @var string $date_time_local data e hora da previsão */
            'date_time_local' => null,
            /** @var int $icon_code código do icone para exibição */
            'icon_code' => null,
            /** @var int $temperature temperatura */
            'temperature' => null,
            /** @var int $temperature_min temperatura mínima */
            'temperature_min' => null,
            /** @var int $temperature_max temperatura máxima */
            'temperature_max' => null,
            /** @var int $precipitation_probability probabilidade de precipitação */
            'precipitation_probability' => null,
            /** @var int $precipitation_amount precipitação (em milimetros ex: 50mm) */
            'precipitation_amount' => null,
            /** @var int $wind_speed vento velocidade (em km/h ex: 13km/h) */
            'wind_speed' => null,
            /** @var int $relative_humidity umidade relativa */
            'relative_humidity' => null,
            /** @var int $dew_point ponto de orvalho */
            'dew_point' => null,
        ];
    }
}
