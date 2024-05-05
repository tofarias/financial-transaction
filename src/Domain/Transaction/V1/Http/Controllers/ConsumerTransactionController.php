<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Domain\Notification\V1\NotificationConsumer;

/**
 * ConsumerTransactions
 * @tags Transactions
 */
class ConsumerTransactionController extends Controller
{
    /**
     * Consumer.
     *
     * @param Request $request description
     *
     */
    public function __invoke(Request $request)
    {
        app(NotificationConsumer::class)->receiveNotification($request->transaction);
    }
}
