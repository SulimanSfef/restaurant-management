<?php

namespace App\Http\Controllers;

use App\Services\WalletService;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\ChargeWalletRequest;

class WalletController extends Controller
{
    use ApiResponseTrait;

    protected $service;

    public function __construct(WalletService $service)
    {
        $this->service = $service;
    }

    public function balance()
    {
        $userId = auth()->id();
        $balance = $this->service->getBalance($userId);
        return $this->successResponse(['balance' => $balance]);
    }

    public function transactions()
    {
        $userId = auth()->id();
        $txns = $this->service->getTransactions($userId);
        return $this->successResponse($txns);
    }

    public function charge(ChargeWalletRequest $request)
    {
        $userId = auth()->id();
        $txn = $this->service->charge($userId, $request->amount, $request->note);
        return $this->successResponse($txn, 'Wallet charged successfully', 201);
    }

    public function payOrder($orderId)
    {
        $userId = auth()->id();
        $result = $this->service->payOrderWithWallet((int)$orderId, (int)$userId);

        if (isset($result['error'])) {
            return $this->errorResponse($result['message'], 422);
        }

        return $this->successResponse($result, 'Order paid via wallet');
    }
}
