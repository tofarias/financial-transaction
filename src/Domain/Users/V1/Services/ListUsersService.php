<?php

declare(strict_types=1);

namespace Domain\Users\V1\Services;

use Domain\Users\V1\Infra\UserQuery;
use Domain\Shared\Services\BaseServiceExecute;

class ListUsersService extends BaseServiceExecute
{
    public function execute(): mixed
    {
        $docType = $this->dto->valid_data->doc_type;
        $userId = $this->dto->valid_data->id;

        return UserQuery::fetchAll($docType, $userId);
    }
}
