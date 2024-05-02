<?php

declare(strict_types=1);

namespace Database\Factories;

use Domain\Users\V1\Enums\EnumDocType;
use Domain\Users\V1\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /** The current password being used by the factory. */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'doc_number' => function (array $attr) {
                return $this->when($attr['doc_type'] == EnumDocType::CPF, function () {
                    return $this->faker->unique()->cpf(false);
                }, function () {
                    return $this->faker->unique()->cnpj(false);
                });
            },
            'password' => static::$password ??= Hash::make('123'),
        ];
    }

    /** Indicate that the model's email address should be unverified. */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
