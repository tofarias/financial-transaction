<?php

declare(strict_types=1);

namespace Domain\Users\V1\Models;

use Database\Factories\UserFactory;
use Domain\Wallets\V1\Models\Wallet;
use Domain\Users\V1\Enums\EnumDocType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'doc_type',
        'doc_number',
        'password',
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
        'password' => 'hashed',
        'doc_type' => EnumDocType::class,
    ];

    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    /** Usuário "comum" */
    public function isCommon(): bool
    {
        return $this->doc_type === EnumDocType::CPF;
    }

    /** Usuário "lojista" */
    public function isShopkeeper(): bool
    {
        return $this->doc_type === EnumDocType::CNPJ;
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }
}
