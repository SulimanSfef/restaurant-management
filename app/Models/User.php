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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $fillable = ['name', 'email', 'password', 'role'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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

    public function sendPasswordResetNotification($token)
{
    $this->notify(new ResetPasswordApiNotification($token));
}

  /**
     * علاقة المستخدم مع الطلبات (Orders)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
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
}
