<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Models;

use Illuminate\Support\Carbon;
use Domain\Wallets\V1\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'value',
        'payer_wallet_id',
        'payee_wallet_id',
        'is_authorized',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];

    public function uniqueIds(): array
    {
        return ['signature'];
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->setTimezone('America/Sao_Paulo')->toDateTimeString(),
        );
    }

    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->setTimezone('America/Sao_Paulo')->toDateTimeString(),
        );
    }

    protected static function newFactory(): Factory
    {
        return TransactionFactory::new();
    }

    public function payerWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'payer_wallet_id');
    }

    public function payeeWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'payee_wallet_id');
    }
}
