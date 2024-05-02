<?php

declare(strict_types=1);

namespace Domain\Wallets\V1\Services;

use Domain\Shared\Services\BaseServiceExecute;

class ListWalletsService extends BaseServiceExecute
{
    public function execute(): mixed
    {
        return WalletQuery::fetchAll($this->dto->valid_data->doc_type);
    }
}
