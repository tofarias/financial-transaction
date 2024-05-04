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
            $table->foreignId('payer_wallet_id')
                ->comment('carteira do usuário pagador')
                ->constrained(
                    table: 'wallets',
                    indexName: 'transaction_payer_walletid'
                );
            $table->foreignId('payee_wallet_id')
                ->comment('carteira do usuário beneficiário, lojista')
                ->constrained(
                    table: 'wallets',
                    indexName: 'transaction_payee_wallet_id'
                );
            $table->uuid('signature');
            $table->double('value', 8, 2);
            $table->boolean('is_authorized')->default(0);

            $table->timestamps();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
