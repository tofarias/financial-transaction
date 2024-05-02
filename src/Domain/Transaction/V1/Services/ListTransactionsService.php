<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Services;

use Domain\Shared\Services\BaseServiceExecute;

class ListTransactionsService extends BaseServiceExecute
{
    public function execute(): mixed
    {
        return TransactionQuery::fetchAll($this->dto->valid_data->doc_type);
    }
}
