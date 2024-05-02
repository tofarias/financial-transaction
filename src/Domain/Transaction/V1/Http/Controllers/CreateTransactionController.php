<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Domain\Shared\Helpers\RequestDTO;
use Domain\Users\V1\Enums\EnumDocType;
use Symfony\Component\HttpFoundation\Response;
use Domain\Transaction\V1\Services\CreateTransactionService;
use Domain\Transaction\V1\Http\Resources\TransactionResource;
use Domain\Transaction\V1\Http\Resources\TransactionCollection;
use Illuminate\Database\Query\Builder;

/**
 * CreateTransactions
 * @tags Transactions
 */
class CreateTransactionController extends Controller
{
    /**
     * Create.
     *
     * @param Request $request description
     * @throws Some_Exception_Class description of exception
     * @return TransactionCollection
     */
    public function __invoke(Request $request)
    {
        $validData = $request->validate([
            'value' => 'required|numeric|gt:0',
            'payer' => [
                'required',
                Rule::exists('users', 'id')->where(
                    static fn (Builder $buider) => $buider->where('doc_type', EnumDocType::CPF)
                ),
            ],
            'payee' => 'required|exists:users,id',
        ]);

        $dto = app(RequestDTO::class);
        $dto->valid_data = new RequestDTO($validData);

        $data = app(CreateTransactionService::class)->withParams($dto)->execute();

        return (new TransactionResource($data))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
