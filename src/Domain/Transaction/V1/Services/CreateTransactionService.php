<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Services;

use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Domain\Shared\Services\BaseServiceExecute;
use Domain\Notification\V1\NotificationService;
use Domain\Users\V1\Infra\Interfaces\UserQuery as UserQueryInterface;
use Domain\Transaction\V1\Enums\CacheFetchAllEnum;
use Domain\Transaction\V1\Exceptions\TransactionException;
use Domain\Integrations\Authorization\AuthorizationService;
use Domain\Transaction\V1\Infra\Interfaces\TransactionCommand as TransactionCommandInterface;
use Domain\Wallets\V1\Infra\Interfaces\WalletCommand as WalletCommandInterface;

class CreateTransactionService extends BaseServiceExecute
{
    public function __construct(
        private UserQueryInterface $userQuery,
        private TransactionCommandInterface $transactionCommand,
        private WalletCommandInterface $walletCommand
    ) {
    }

    public function execute(): mixed
    {
        $dtoValidData = $this->dto->valid_data;

        $payer = $this->userQuery->findById($dtoValidData->payer);
        $payee = $this->userQuery->findById($dtoValidData->payee);
        $value = $dtoValidData->value;

        if($payer->isShopkeeper()) {
            throw TransactionException::PayerCannotBeAShopkeeper();
        }

        DB::beginTransaction();

        try {
            $newTransaction = $this->transactionCommand->create(
                $payer->wallet,
                $payee->wallet,
                $value
            );

            $isAuthorized = app(AuthorizationService::class)->isAuthorized();
            $this->transactionCommand->updateStatus($newTransaction->id, $isAuthorized);

            $this->when($isAuthorized, function () use ($newTransaction, $payer, $payee) {
                $this->walletCommand->debit($payer->wallet, $newTransaction->value);
                $this->walletCommand->credit($payee->wallet, $newTransaction->value);
                app(NotificationService::class)->notify($newTransaction);
            });

            DB::commit();

            self::cacheForget();

            return $newTransaction->fresh();
        } catch (Throwable $th) {
            DB::rollBack();

            throw new TransactionException($th->getMessage());
        }
    }

    protected static function cacheForget(): void
    {
        Cache::forget(CacheFetchAllEnum::FETCH_ALL->value);
    }
}
