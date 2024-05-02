<?php

declare(strict_types=1);

namespace Domain\Users\V1\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Domain\Shared\Helpers\RequestDTO;
use Domain\Users\V1\Enums\EnumDocType;
use Domain\Users\V1\Services\ListUsersService;
use Symfony\Component\HttpFoundation\Response;
use Domain\Users\V1\Http\Resources\UserResource;
use Domain\Users\V1\Http\Resources\UserCollection;

/**
 * ListUsersController
 * @tags Users
 */
class ListUsersController extends Controller
{
    /**
     * List.
     *
     * @param Request $request description
     * @throws Some_Exception_Class description of exception
     * @return UserCollection
     */
    public function __invoke(Request $request)
    {
        $validData = $request->validate([
            'doc_type' => ['nullable', Rule::in(EnumDocType::cases())],
        ]);

        $dto = app(RequestDTO::class);
        $dto->valid_data = new RequestDTO($validData);

        $data = app(ListUsersService::class)->withParams($dto)->execute();

        return (UserResource::collection($data))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
