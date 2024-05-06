<?php

declare(strict_types=1);

namespace Domain\Notification\V1\Interfaces;

use Domain\Transaction\V1\Models\Transaction;

interface NotificationService
{
    public function notify(Transaction $transaction);
}
