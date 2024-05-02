<?php

declare(strict_types=1);

namespace Database\Factories;

use Domain\Transaction\V1\Models\Transaction;
use Domain\Users\V1\Enums\EnumDocType;
use Domain\Users\V1\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'payee_wallet_id' => User::query()->where('doc_type', EnumDocType::CNPJ)->inRandomOrder()->first()->id,
            'value' => $this->faker->randomFloat(2, $min = 0, $max = 1000),
        ];
    }
}
