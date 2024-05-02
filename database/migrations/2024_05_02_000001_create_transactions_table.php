<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payer_id')
                ->comment('usuário pagador')
                ->constrained(
                    table: 'users',
                    indexName: 'transaction_payer_id'
                );
            $table->foreignId('payee_id')
                ->comment('usuário beneficiário, lojista')
                ->constrained(
                    table: 'users',
                    indexName: 'transaction_payee_id'
                );
            $table->double('value', 8, 2);

            $table->timestamps();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
