<?php

declare(strict_types=1);

namespace Domain\Shared\Helpers;

use Illuminate\Support\Fluent;

/**
 * Data Transfer Object
 *
 * Transfer data to the next layer
 */
class RequestDTO extends Fluent
{
    public RequestDTO $valid_data;
}
