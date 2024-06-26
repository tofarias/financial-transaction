<?php

declare(strict_types=1);

namespace Domain\Users\V1\Enums;

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

    public function getLabel(): string
    {
        return match ($this) {
            self::CPF => 'COMUM',
            self::CNPJ => 'LOJISTA',
        };
    }
}
