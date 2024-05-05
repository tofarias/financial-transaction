<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Services;

use Domain\Shared\Services\BaseServiceExecute;
use Domain\Transaction\V1\Infra\TransactionQuery;

class ListTransactionsService extends BaseServiceExecute
{
    public function execute(): mixed
    {
        $userId = (int) $this->dto->valid_data->user_id;

        return TransactionQuery::fetchAll($userId);
    }
}
