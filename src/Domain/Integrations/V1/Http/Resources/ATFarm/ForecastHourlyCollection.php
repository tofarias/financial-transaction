<?php

declare(strict_types=1);

namespace Domain\Integrations\V1\Http\Resources\ATFarm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class ForecastHourlyCollection extends ResourceCollection
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $collection = $this->collection;
        $data = new Collection();
        foreach ($collection as $key => $item) {
            $data->push([
                'date_time_local' => data_get($item, 'dateTimeLocal'),
                'icon_code' => data_get($item, 'iconCode'),
                'temperature' => data_get($item, 'temperature'),
                'temperature_min' => data_get($item, 'temperatureMin'),
                'temperature_max' => data_get($item, 'temperatureMax'),
                'precipitation_probability' => data_get($item, 'precipitationProbability'),
                'precipitation_amount' => data_get($item, 'precipitationAmount'),
                'wind_speed' => data_get($item, 'windSpeed'),
                'relative_humidity' => data_get($item, 'relativeHumidity'),
                'dew_point' => data_get($item, 'dewPoint'),
            ]);
        }

        return $data->toArray();
    }
}
