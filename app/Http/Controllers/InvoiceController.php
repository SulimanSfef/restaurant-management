<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Services\InvoiceService;
use App\Traits\ApiResponseTrait;

class InvoiceController extends Controller
{
    use ApiResponseTrait;

    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    // الحصول على جميع الفواتير
    public function index()
    {
        $invoices = $this->invoiceService->getAllInvoices();
        return $this->successResponse($invoices, 'تم جلب الفواتير بنجاح');
    }

    // إنشاء فاتورة جديدة
    public function store(InvoiceRequest $request)
    {
        $invoice = $this->invoiceService->createInvoice($request->validated());
        return $this->successResponse($invoice, 'تم إنشاء الفاتورة بنجاح', 201);
    }

    // الحصول على تفاصيل فاتورة معينة
    public function show($id)
    {
        try {
            $invoice = $this->invoiceService->getInvoiceById($id);
            return $this->successResponse($invoice, 'تم جلب الفاتورة بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse('الفاتورة غير موجودة', 404);
        }
    }

    // تحديث الفاتورة
    public function update(InvoiceRequest $request, $id)
    {
        try {
            $invoice = $this->invoiceService->updateInvoice($id, $request->validated());
            return $this->successResponse($invoice, 'تم تحديث الفاتورة بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse('تعذر تحديث الفاتورة', 404);
        }
    }

    // حذف الفاتورة
    public function destroy($id)
    {
        try {
            $this->invoiceService->deleteInvoice($id);
            return $this->successResponse(null, 'تم حذف الفاتورة بنجاح', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('تعذر حذف الفاتورة', 404);
        }
    }
}
