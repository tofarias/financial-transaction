<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Services;

use Domain\Shared\Services\BaseServiceExecute;
use Domain\Transaction\V1\Infra\Interfaces\TransactionQuery;

class ListTransactionsService extends BaseServiceExecute
{
    public function execute(): mixed
    {
        $userId = (int) $this->dto->valid_data->user_id;

        return app(TransactionQuery::class)->fetchAll($userId);
    }
}
