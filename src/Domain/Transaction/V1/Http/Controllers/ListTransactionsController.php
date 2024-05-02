<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Domain\Shared\Helpers\RequestDTO;
use Domain\Users\V1\Enums\EnumDocType;
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
     * @throws Some_Exception_Class description of exception
     * @return TransactionCollection
     */
    public function __invoke(Request $request)
    {
        $validData = $request->validate([
            /**
             * Tipo de beneficiário.
             */
            'payee_doc_type' => ['nullable', Rule::in(EnumDocType::cases())],
        ]);

        $dto = app(RequestDTO::class);
        $dto->valid_data = new RequestDTO(['doc_type' => $validData['payee_doc_type'] ?? null]);

        $data = app(ListTransactionsService::class)->withParams($dto)->execute();

        return (TransactionResource::collection($data))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
