<?php

declare(strict_types=1);

namespace Domain\Users\V1\Services;

use Domain\Shared\Services\BaseServiceExecute;

class ListUsersService extends BaseServiceExecute
{
    public function execute(): mixed
    {
        return UserQuery::fetchAll($this->dto->valid_data->doc_type);
    }
}
