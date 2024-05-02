<?php

declare(strict_types=1);

namespace Domain\Integrations\V1\Http\Controllers;

use Illuminate\Http\Request;
use Domain\Shared\Helpers\RequestDTO;
use Symfony\Component\HttpFoundation\Response;
use Domain\Integrations\V1\Services\GetForecastHourly;
use Domain\Integrations\V1\Http\Resources\ATFarm\ForecastHourlyCollection;

class WeatherController
{
    /**
     * Forecast Hourly.
     *
     * @param Request $request description
     * @throws Some_Exception_Class description of exception
     * @return ForecastHourlyCollection
     */
    public function __invoke(Request $request)
    {
        $validData = $request->validate([
            'city' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'days_limit' => 'required|integer',
        ]);

        $dto = app(RequestDTO::class);
        $dto->valid_data = new RequestDTO($validData);

        $data = app(GetForecastHourly::class)->withParams($dto)->execute();

        return (new ForecastHourlyCollection($data))
            ->response()->setStatusCode(Response::HTTP_OK);
    }
}
