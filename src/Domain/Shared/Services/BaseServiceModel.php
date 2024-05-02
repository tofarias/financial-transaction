<?php

declare(strict_types=1);

namespace Domain\Shared\Services;

use Illuminate\Support\Traits\Conditionable;

abstract class BaseServiceModel
{
    use Conditionable;
}
