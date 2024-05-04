<?php

declare(strict_types=1);

namespace Domain\Integrations\Authorization\Enums;

enum AuthorizationEnum: string
{
    case MESSAGE_AUTHORIZED = 'Autorizado';

    public function isAuthorized(): bool
    {
        return $this === self::MESSAGE_AUTHORIZED;
    }
}
