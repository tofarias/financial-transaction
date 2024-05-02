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

    /** Usuário "comum" */
    public function isCommon(): bool
    {
        return $this === self::CPF;
    }

    /** Usuário "lojista" */
    public function isShopkeeper(): bool
    {
        return $this === self::CNPJ;
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::CPF => 'COMUM',
            self::CNPJ => 'LOJISTA',
        };
    }
}
