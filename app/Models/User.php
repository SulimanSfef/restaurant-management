<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordApiNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


   protected $fillable = ['name', 'email', 'password', 'role','profile_image'];

  
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

  /**
     * علاقة المستخدم مع الطلبات (Orders)
     */
   public function orders()
{
    return $this->hasMany(Order::class);
}

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * علاقة المستخدم مع الفواتير (Invoices)
     */
    public function invoices()
    {
        return $this->hasManyThrough(Invoice::class, Order::class);
    }

    /**
     * علاقة المستخدم مع رموز الوصول الشخصية (Tokens)
     */
    // public function tokens()
    // {
    //     return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    // }

    /**
     * علاقة المستخدم مع رموز التحديث (Refresh Tokens)
     */
    public function refreshTokens()
    {
        return $this->hasMany(RefreshToken::class);
    }


    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function addresses()
   {
    return $this->hasMany(Address::class);
   }

   public function reservations()
{
    return $this->hasMany(Reservation::class);
}


public function wallet()
{
    return $this->hasOne(\App\Models\Wallet::class);
}

public function walletTransactions()
{
    return $this->hasManyThrough(
        \App\Models\WalletTransaction::class,
        \App\Models\Wallet::class,
        'user_id',     // Foreign key on wallets table...
        'wallet_id',   // Foreign key on wallet_transactions table...
        'id',          // Local key on users table...
        'id'           // Local key on wallets table...
    );
}

}
