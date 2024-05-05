<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Enums;

enum CacheFetchAllEnum: string
{
    case FETCH_ALL = 'transaction_fetch_all:';
}
