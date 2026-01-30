<?php

use App\Livewire\PosPage;
use Illuminate\Support\Facades\Route;

Route::get('/', PosPage::class)->name('pos.index');
Route::get('/invoice/{invoiceCode}', [App\Http\Controllers\InvoiceController::class, 'print'])->name('invoice.print');
Route::get('/report', App\Livewire\ReportPage::class)->name('report.index');
