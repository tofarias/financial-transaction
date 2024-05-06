<?php

declare(strict_types=1);

namespace Domain\Shared\Services;

use Domain\Shared\Helpers\RequestDTO;
use Exception;
use Illuminate\Support\Traits\Conditionable;

abstract class BaseServiceExecute
{
    use Conditionable;

    public RequestDTO $dto;

    /**
     * A description of the entire PHP function.
     *
     * @param RequestDTO $dto description
     * @return self
     */
    public function withParams(RequestDTO $dto): self
    {
        $this->dto = $dto;

        return $this;
    }

    abstract public function execute(): mixed;

    protected function validate(): void
    {
        throw new Exception('Not implemented');
    }
}
