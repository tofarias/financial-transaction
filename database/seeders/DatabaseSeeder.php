<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Domain\Users\Models\User;
use Illuminate\Database\Seeder;
use Domain\Users\Enums\EnumDocType;

class DatabaseSeeder extends Seeder
{
    /** Seed the application's database. */
    public function run(): void
    {
        User::factory(10)->create(['doc_type' => EnumDocType::CPF]);
        User::factory(3)->create(['doc_type' => EnumDocType::CNPJ]);
    }
}
