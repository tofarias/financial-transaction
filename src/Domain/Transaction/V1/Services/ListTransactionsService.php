<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Services;

use Domain\Shared\Services\BaseServiceExecute;

class ListTransactionsService extends BaseServiceExecute
{
    public function execute(): mixed
    {
        $userId = (int) $this->dto->valid_data->user_id;

        return TransactionQuery::fetchAll($userId);
    }
}
