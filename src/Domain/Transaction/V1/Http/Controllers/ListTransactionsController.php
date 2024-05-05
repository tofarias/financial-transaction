<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Domain\Shared\Helpers\RequestDTO;
use Symfony\Component\HttpFoundation\Response;
use Domain\Transaction\V1\Services\ListTransactionsService;
use Domain\Transaction\V1\Http\Resources\TransactionResource;
use Domain\Transaction\V1\Http\Resources\TransactionCollection;

/**
 * ListTransactions
 * @tags Transactions
 */
class ListTransactionsController extends Controller
{
    /**
     * List.
     *
     * @param Request $request description
     *
     * @return TransactionCollection
     */
    public function __invoke(Request $request): JsonResponse
    {
        $validData = $request->validate([
            /**
             * usuário comum ou lojista
             */
            'user_id' => 'nullable|exists:users,id',
        ]);

        $dto = app(RequestDTO::class);
        $dto->valid_data = new RequestDTO($validData);

        $data = app(ListTransactionsService::class)->withParams($dto)->execute();

        return (TransactionResource::collection($data))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
