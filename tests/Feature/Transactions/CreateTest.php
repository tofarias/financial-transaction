<?php

declare(strict_types=1);

use Database\Seeders\DatabaseSeeder;

use function Pest\Laravel\postJson;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('should return 200', function () {

    postJson(
        route('v1:transactions.transfer'),
        [
            'value' => 101,
            'payer' => 4,
            'payee' => 2,
        ]
    )
        ->assertCreated()
        ->assertJsonStructure([
            'id',
            'value',
            'is_authorized',
            'created_at',
            'updated_at',
            'payer_wallet' => [
                'id',
                'balance'
            ],
            'payee_wallet' => [
                'id',
                'balance'
            ],
        ]);
});
