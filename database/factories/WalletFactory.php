<?php

declare(strict_types=1);

namespace Database\Factories;

use Domain\Wallets\V1\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'password' => function (array $attr) {
                return Hash::make('000'.$attr['user_id']);
            },
            'balance' => $this->faker->randomFloat(2, $min = 0, $max = 1000),
        ];
    }
}
