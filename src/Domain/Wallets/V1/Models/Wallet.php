<?php

declare(strict_types=1);

namespace Domain\Wallets\V1\Models;

use Domain\Users\V1\Models\User;
use Database\Factories\WalletFactory;
use Illuminate\Database\Eloquent\Model;
use Domain\Transaction\V1\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];

    protected static function newFactory(): Factory
    {
        return WalletFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payerTransactinons(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payer_wallet_id');
    }

    public function payeeTransactinons(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payee_wallet_id');
    }
}
