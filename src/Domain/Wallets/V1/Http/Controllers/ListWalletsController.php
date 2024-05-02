<?php

declare(strict_types=1);

namespace Domain\Wallets\V1\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Domain\Shared\Helpers\RequestDTO;
use Domain\Users\V1\Enums\EnumDocType;
use Symfony\Component\HttpFoundation\Response;
use Domain\Wallets\V1\Services\ListWalletsService;
use Domain\Wallets\V1\Http\Resources\WalletResource;
use Domain\Wallets\V1\Http\Resources\WalletCollection;

/**
 * ListWalletsController
 * @tags Wallets
 */
class ListWalletsController extends Controller
{
    /**
     * List.
     *
     * @param Request $request description
     * @throws Some_Exception_Class description of exception
     * @return WalletCollection
     */
    public function __invoke(Request $request)
    {
        $validData = $request->validate([
            'doc_type' => ['nullable', Rule::in(EnumDocType::cases())],
        ]);

        $dto = app(RequestDTO::class);
        $dto->valid_data = new RequestDTO($validData);

        $data = app(ListWalletsService::class)->withParams($dto)->execute();

        return (WalletResource::collection($data))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
