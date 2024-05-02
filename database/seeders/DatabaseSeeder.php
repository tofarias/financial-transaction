<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Domain\Transaction\V1\Models\Transaction;
use Illuminate\Database\Seeder;
use Domain\Users\V1\Models\User;
use Domain\Users\V1\Enums\EnumDocType;

class DatabaseSeeder extends Seeder
{
    /** Seed the application's database. */
    public function run(): void
    {
        User::factory(2)->create(['doc_type' => EnumDocType::CNPJ]);

        User::factory(1)
        ->has( Transaction::factory(1) )
        ->create([
            'doc_type' => EnumDocType::CPF,
            'timezone' => 'America/Sao_Paulo',
        ]);

        User::factory(1)
        ->create([
            'doc_type' => EnumDocType::CPF,
            'timezone' => 'America/Rio_Branco',
        ]);

        User::factory(1)
        ->has( Transaction::factory(1) )
        ->create([
            'doc_type' => EnumDocType::CPF,
            'timezone' => 'America/Manaus',
        ]);
        
    }
}
