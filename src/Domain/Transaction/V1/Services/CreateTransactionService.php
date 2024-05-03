<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Services;

use Domain\Integrations\V1\Api\Authorization\AuthorizationService;
use Domain\Users\V1\Services\UserQuery;
use Domain\Shared\Services\BaseServiceExecute;
use Domain\Transaction\V1\Exceptions\TransactionException;
use Domain\Wallets\V1\Services\WalletCommand;
use Illuminate\Support\Facades\DB;

class CreateTransactionService extends BaseServiceExecute
{
    public function execute(): mixed
    {
        $dtoValidData = $this->dto->valid_data;

        $payer = UserQuery::findById($dtoValidData->payer);
        $payee = UserQuery::findById($dtoValidData->payee);
        $value = $dtoValidData->value;

        if($payer->isShopkeeper()) {
            throw new TransactionException('Payer cannot be a shopkeeper');
        }

        return DB::transaction(function () use ($payer, $payee, $value) {
            $newTransaction = TransactionCommand::create(
                $payer->wallet,
                $payee->wallet,
                $value
            );

            WalletCommand::debit($payer->wallet, $newTransaction->value);
            WalletCommand::credit($payee->wallet, $newTransaction->value);

            app(AuthorizationService::class)->getAuthorization();

            return $newTransaction;
        });
    }
}
