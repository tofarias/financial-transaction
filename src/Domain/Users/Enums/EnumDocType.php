<?php

declare(strict_types=1);

namespace Domain\Users\Enums;

enum EnumDocType: string
{
    /**
     * Referente ao usuário "comun"
     */
    case CPF = 'CPF';
    /**
     * Referente ao usuário "lojista"
     */
    case CNPJ = 'CNPJ';
}
