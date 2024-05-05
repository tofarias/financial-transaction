<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Domain\Shared\Helpers\RequestDTO;
use Domain\Users\V1\Enums\EnumDocType;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Domain\Transaction\V1\Services\CreateTransactionService;
use Domain\Transaction\V1\Http\Resources\TransactionResource;
use Domain\Transaction\V1\Http\Resources\TransactionCollection;

/**
 * CreateTransactions
 * @tags Transactions
 */
class CreateTransactionController extends Controller
{
    /**
     * Transfer.
     *
     * @param Request $request description
     *
     * @return TransactionCollection
     */
    public function __invoke(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'value' => 'required|numeric|gt:0',
                'payer' => [
                    'required',
                    Rule::exists('users', 'id')->where(
                        static fn (Builder $buider) => $buider->where('doc_type', EnumDocType::CPF)
                    ),
                ],
                'payee' => 'required|exists:users,id',
            ],
            [
                'value.gt' => 'The value must be greater than 0',
                'payer.exists' => 'Payer is not a common user or not exists',
                'payee.exists' => 'Payee not exists',
            ]
        );

        $dto = app(RequestDTO::class);
        $dto->valid_data = new RequestDTO($validator->validated());

        $data = app(CreateTransactionService::class)->withParams($dto)->execute();

        return (new TransactionResource($data))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
