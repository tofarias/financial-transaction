<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Exceptions;

use DomainException;
use Symfony\Component\HttpFoundation\Response;

class TransactionException extends DomainException
{
    public static function PayerCannotBeAShopkeeper()
    {
        return new static('Payer cannot be a shopkeeper',Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function ValueIsGreaterThanWalletBalance()
    {
        return new static('The value is greater than wallet balance',Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function PayerCannotTransferToHimself()
    {
        return new static('payer cannot transfer to himself',Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
