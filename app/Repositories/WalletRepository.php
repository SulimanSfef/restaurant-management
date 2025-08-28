<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository
{
    public function getOrCreateByUser(int $userId): Wallet
    {
        return Wallet::firstOrCreate(['user_id' => $userId], ['balance' => 0]);
    }

    public function updateBalance(Wallet $wallet, float $newBalance): Wallet
    {
        $wallet->balance = $newBalance;
        $wallet->save();
        return $wallet;
    }
}
