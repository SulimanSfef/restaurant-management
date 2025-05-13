<?php

namespace App\Services;

use App\Repositories\InvoiceRepository;

class InvoiceService
{
    protected $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function getAllInvoices()
    {
        return $this->invoiceRepository->getAllInvoices();
    }

    public function createInvoice($data)
    {
        return $this->invoiceRepository->createInvoice($data);
    }

    public function getInvoiceById($id)
    {
        return $this->invoiceRepository->getInvoiceById($id);
    }

    public function updateInvoice($id, $data)
    {
        return $this->invoiceRepository->updateInvoice($id, $data);
    }

    public function deleteInvoice($id)
    {
        return $this->invoiceRepository->deleteInvoice($id);
    }
}
