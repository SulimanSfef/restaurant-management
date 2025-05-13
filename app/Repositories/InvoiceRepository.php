<?php
namespace App\Repositories;

use App\Models\Invoice;

class InvoiceRepository
{
    public function getAllInvoices()
    {
        return Invoice::all();
    }

    public function createInvoice($data)
    {
        return Invoice::create($data);
    }

    public function getInvoiceById($id)
    {
        return Invoice::findOrFail($id);
    }

    public function updateInvoice($id, $data)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update($data);
        return $invoice;
    }

    public function deleteInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        return $invoice->delete();
    }
}
