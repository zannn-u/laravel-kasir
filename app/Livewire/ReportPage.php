<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportPage extends Component
{
    #[Title('Sales Report')]
    #[Layout('components.layouts.app')]

    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $transactions = Transaction::whereBetween('created_at', [
            $this->startDate . ' 00:00:00',
            $this->endDate . ' 23:59:59'
        ])
            ->latest()
            ->get();

        return view('livewire.report-page', [
            'transactions' => $transactions,
            'totalRevenue' => $transactions->sum('total_amount'),
            'totalTransactions' => $transactions->count(),
        ]);
    }
}
