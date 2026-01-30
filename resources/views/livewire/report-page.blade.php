<div class="min-h-screen bg-slate-50 font-sans text-slate-900">
    <!-- Navigation Bar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-600 p-1.5 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-800">Kasir Reports</span>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('pos.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="-ml-1 mr-2 h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to POS
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header & Date Filter Row -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Overview</h1>
                <p class="text-sm text-slate-500 mt-1">Performance summary for <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</span> to <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</span></p>
            </div>
            
            <div class="bg-white p-1.5 rounded-lg border border-slate-200 shadow-sm flex items-center gap-2">
                <div class="relative">
                    <input type="date" wire:model.live="startDate" class="block w-full pl-3 pr-10 py-1.5 text-sm border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md border-0 bg-transparent text-slate-600 font-medium">
                </div>
                <span class="text-slate-400 font-medium">-</span>
                <div class="relative">
                    <input type="date" wire:model.live="endDate" class="block w-full pl-3 pr-10 py-1.5 text-sm border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md border-0 bg-transparent text-slate-600 font-medium">
                </div>
            </div>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Revenue Card -->
            <div class="relative overflow-hidden rounded-2xl p-6 text-white shadow-lg group transition-all hover:scale-[1.02]"
                style="background: linear-gradient(135deg, #0F172A 0%, #1e40af 100%);">
                
                <div class="absolute right-0 top-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white opacity-10 blur-xl"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 h-20 w-20 rounded-full bg-blue-400 opacity-20 blur-xl"></div>
                
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div>
                        <div class="flex items-center gap-2 text-blue-100 mb-2">
                            <span class="text-sm font-semibold uppercase tracking-wider">Total Revenue</span>
                        </div>
                        <h3 class="text-3xl font-bold tracking-tight text-white mb-1">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </h3>
                    </div>
                     <div class="mt-4 flex items-center text-xs text-blue-200">
                        <svg class="mr-1 h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <span>Gross Income</span>
                    </div>
                </div>
            </div>

            <!-- Transactions Card -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 hover:border-blue-400 transition-colors group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Transactions</p>
                    <div class="bg-blue-50 p-2 rounded-lg group-hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-slate-800 tracking-tight">{{ $totalTransactions }}</h3>
                <p class="text-xs text-slate-400 mt-2">Paid orders in period</p>
            </div>
            
            <!-- Avg Transaction Card -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 hover:border-purple-400 transition-colors group">
                 <div class="flex items-center justify-between mb-4">
                    <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Avg. Size</p>
                    <div class="bg-purple-50 p-2 rounded-lg group-hover:bg-purple-100 transition-colors">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                 <h3 class="text-3xl font-bold text-slate-800 tracking-tight">
                    @if($totalTransactions > 0)
                        Rp {{ number_format($totalRevenue / $totalTransactions, 0, ',', '.') }}
                    @else
                        -
                    @endif
                 </h3>
                 <p class="text-xs text-slate-400 mt-2">Average value per invoice</p>
            </div>

            <!-- Transactions Count Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:border-blue-400 transition-colors group">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-50 p-3 rounded-xl group-hover:bg-blue-100 transition-colors">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>
                <p class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Total Transactions</p>
                <h3 class="text-3xl font-bold text-slate-800 tracking-tight">{{ $totalTransactions }}</h3>
                <p class="text-xs text-slate-400 mt-2">Paid orders in period</p>
            </div>
            
            <!-- Avg Value Card (Computed on the fly if needed, or simplified) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:border-purple-400 transition-colors group">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-purple-50 p-3 rounded-xl group-hover:bg-purple-100 transition-colors">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                 <p class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Avg. Transaction</p>
                 <h3 class="text-3xl font-bold text-slate-800 tracking-tight">
                    @if($totalTransactions > 0)
                        Rp {{ number_format($totalRevenue / $totalTransactions, 0, ',', '.') }}
                    @else
                        Rp 0
                    @endif
                 </h3>
                 <p class="text-xs text-slate-400 mt-2">Average order value</p>
            </div>
        </div>

        <!-- Transactions Table Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-lg text-slate-800">Transaction History</h3>
                <button class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">Export All</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-slate-400 uppercase border-b border-slate-100">
                            <th class="px-6 py-4 bg-slate-50/50 rounded-tl-2xl">Date</th>
                            <th class="px-6 py-4 bg-slate-50/50">Invoice</th>
                            <th class="px-6 py-4 bg-slate-50/50 text-center">Qty</th>
                            <th class="px-6 py-4 bg-slate-50/50 text-right">Total Amount</th>
                            <th class="px-6 py-4 bg-slate-50/50 text-center">Status</th>
                            <th class="px-6 py-4 bg-slate-50/50 text-center rounded-tr-2xl">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <div class="font-medium text-slate-900">{{ $transaction->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-slate-400">{{ $transaction->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-mono text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded border border-slate-200 group-hover:border-blue-200 group-hover:text-blue-600 transition-colors">
                                        {{ $transaction->invoice_code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-slate-500">
                                    {{ $transaction->details->count() }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="font-bold text-slate-700">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                                        Paid
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('invoice.print', $transaction->invoice_code) }}" target="_blank" class="inline-flex items-center justify-center p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Print Invoice">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="mx-auto w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    </div>
                                    <h3 class="text-slate-900 font-medium text-lg">No transactions found</h3>
                                    <p class="text-slate-500 mt-1">There are no sales in the selected date range.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination (Placeholder if needed) -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 rounded-b-2xl">
                 <p class="text-xs text-slate-400 text-center">Showing latest transactions</p>
            </div>
        </div>
    </main>
</div>