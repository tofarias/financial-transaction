<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Services;

use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Domain\Users\V1\Services\UserQuery;
use Domain\Wallets\V1\Services\WalletCommand;
use Domain\Shared\Services\BaseServiceExecute;
use Domain\Notification\V1\NotificationService;
use Domain\Transaction\V1\Enums\CacheFetchAllEnum;
use Domain\Transaction\V1\Exceptions\TransactionException;
use Domain\Integrations\Authorization\AuthorizationService;

class CreateTransactionService extends BaseServiceExecute
{
    public function execute(): mixed
    {
        $dtoValidData = $this->dto->valid_data;

        $payer = UserQuery::findById($dtoValidData->payer);
        $payee = UserQuery::findById($dtoValidData->payee);
        $value = $dtoValidData->value;

        if($payer->isShopkeeper()) {
            throw TransactionException::PayerCannotBeAShopkeeper();
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

            app(NotificationService::class)->notify($newTransaction);

            DB::commit();

            self::cacheForget($payer->id, $payee->id);

            return $newTransaction->fresh();
        } catch (Throwable $th) {
            DB::rollBack();

            throw new TransactionException($th->getMessage());
        }
    }

    protected static function cacheForget(int $payerId, int $payeeId): void
    {
        Cache::forget(CacheFetchAllEnum::FETCH_ALL->value.$payerId);
        Cache::forget(CacheFetchAllEnum::FETCH_ALL->value.$payeeId);
    }
}
