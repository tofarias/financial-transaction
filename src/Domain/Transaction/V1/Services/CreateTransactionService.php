<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Services;

use Illuminate\Support\Facades\DB;
use Domain\Users\V1\Services\UserQuery;
use Domain\Wallets\V1\Services\WalletCommand;
use Domain\Shared\Services\BaseServiceExecute;
use Domain\Transaction\V1\Exceptions\TransactionException;
use Domain\Integrations\V1\Api\Authorization\AuthorizationService;
use Throwable;

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

        DB::beginTransaction();

        try {
            $newTransaction = TransactionCommand::create(
                $payer->wallet,
                $payee->wallet,
                $value
            );

            $isAuthorized = app(AuthorizationService::class)->isAuthorized();
            TransactionCommand::updateStatus($newTransaction->id, $isAuthorized);

            $this->when($isAuthorized, function () use ($newTransaction, $payer, $payee) {
                WalletCommand::debit($payer->wallet, $newTransaction->value);
                WalletCommand::credit($payee->wallet, $newTransaction->value);
            });

            DB::commit();

            return $newTransaction->fresh();
        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }
}
