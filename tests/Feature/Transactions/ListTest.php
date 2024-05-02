<?php

declare(strict_types=1);

use Database\Seeders\DatabaseSeeder;

use function Pest\Laravel\getJson;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('should return 200', function () {

    getJson(
        route('v1:transactions.index')
    )
        ->assertOk()
        ->assertJsonStructure([
            '*' => [
                'id',
                'value',
                'created_at',
                'updated_at',
                'payer_wallet' => [
                    'id',
                    'balance',
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'type',
                        'doc_type',
                        'doc_number',
                        'timezone',
                    ],
                ],
                'payee_wallet' => [
                    'id',
                    'balance',
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'type',
                        'doc_type',
                        'doc_number',
                        'timezone',
                    ],
                ],
            ],
        ]);
});
