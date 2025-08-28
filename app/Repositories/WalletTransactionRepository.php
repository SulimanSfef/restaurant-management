<?php

namespace App\Repositories;

use App\Models\WalletTransaction;
use App\Models\Wallet;

class WalletTransactionRepository
{
    public function create(Wallet $wallet, array $data): WalletTransaction
    {
        $data['wallet_id'] = $wallet->id;
        return WalletTransaction::create($data);
    }

    public function getByUser(int $userId)
    {
        return \App\Models\WalletTransaction::whereHas('wallet', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->latest()->get();
    }
}
