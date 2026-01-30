<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function print($invoiceCode)
    {
        $transaction = Transaction::with(['details.product'])
            ->where('invoice_code', $invoiceCode)
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.invoice', compact('transaction'));

        // Setup paper size for receipt (e.g. 80mm width roughly, or just A5/A4)
        $pdf->setPaper('A5', 'portrait');

        return $pdf->stream('invoice-' . $transaction->invoice_code . '.pdf');
    }
}
