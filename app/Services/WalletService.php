<?php

namespace App\Services;

use App\Repositories\WalletRepository;
use App\Repositories\WalletTransactionRepository;
use App\Repositories\OrderRepository;
use App\Repositories\InvoiceRepository;
use Illuminate\Support\Facades\DB;

class WalletService
{
    protected $walletRepo;
    protected $txnRepo;
    protected $orderRepo;
    protected $invoiceRepo;

    public function __construct(
        WalletRepository $walletRepo,
        WalletTransactionRepository $txnRepo,
        OrderRepository $orderRepo,
        InvoiceRepository $invoiceRepo
    ) {
        $this->walletRepo = $walletRepo;
        $this->txnRepo = $txnRepo;
        $this->orderRepo = $orderRepo;
        $this->invoiceRepo = $invoiceRepo;
    }

    public function getBalance(int $userId): float
    {
        return $this->walletRepo->getOrCreateByUser($userId)->balance;
    }

    public function getTransactions(int $userId)
    {
        return $this->txnRepo->getByUser($userId);
    }

    public function charge(int $userId, float $amount, ?string $note = null)
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than 0');
        }

        return DB::transaction(function () use ($userId, $amount, $note) {
            $wallet = $this->walletRepo->getOrCreateByUser($userId);
            $newBalance = $wallet->balance + $amount;
            $this->walletRepo->updateBalance($wallet, $newBalance);

            return $this->txnRepo->create($wallet, [
                'type' => 'charge',
                'amount' => $amount,
                'note' => $note,
            ]);
        });
    }

    public function deduct(int $userId, float $amount, array $ref = [], ?string $note = null): bool
    {
        return DB::transaction(function () use ($userId, $amount, $ref, $note) {
            $wallet = $this->walletRepo->getOrCreateByUser($userId);

            if ($wallet->balance < $amount) {
                return false;
            }

            $newBalance = $wallet->balance - $amount;
            $this->walletRepo->updateBalance($wallet, $newBalance);

            $this->txnRepo->create($wallet, [
                'type' => 'deduct',
                'amount' => $amount,
                'reference_type' => $ref['type'] ?? null,
                'reference_id' => $ref['id'] ?? null,
                'note' => $note,
            ]);

            return true;
        });
    }

    public function payOrderWithWallet(int $orderId, int $userId)
    {
        // اجلب الطلب مع العناصر وأسعارها
        $order = \App\Models\Order::with(['orderItems.menuItem'])->findOrFail($orderId);

        if ($order->status === 'paid') {
            return ['error' => true, 'message' => 'Order already paid'];
        }

        // احسب المجموع
        $total = 0;
        foreach ($order->orderItems as $item) {
            $total += ($item->quantity * ($item->menuItem->price ?? 0));
        }

        if ($total <= 0) {
            return ['error' => true, 'message' => 'Order total is zero'];
        }

        // حاول الخصم
        $deducted = $this->deduct($userId, $total, ['type' => 'order', 'id' => $order->id], 'Pay order via wallet');
        if (!$deducted) {
            return ['error' => true, 'message' => 'Insufficient wallet balance'];
        }

        // حدث حالة الطلب وأنشئ فاتورة
        $order->status = 'paid';
        $order->save();

        $invoice = $this->invoiceRepo->createInvoice([
            'order_id' => $order->id,
            // غيّرها إلى 'wallet' إذا عدلت enum الحقل
            'payment_method' => 'other',
            'total' => $total,
        ]);

        return ['success' => true, 'invoice' => $invoice, 'total' => $total];
    }
}
