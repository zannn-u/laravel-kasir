<div class="flex h-screen bg-gray-100 overflow-hidden">
    <!-- Left Panel: Products -->
    <div class="w-2/3 flex flex-col h-full">
        <!-- Header -->
        <div class="p-4 bg-white shadow-sm flex items-center justify-between z-10">
            <div class="flex items-center space-x-4">
                <h1 class="text-xl font-bold text-gray-800">POS System</h1>
                <a href="{{ route('report.index') }}"
                    class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-1 rounded-full transition-colors font-medium">
                    Sales Report
                </a>
            </div>
            <div class="relative w-1/2">
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Search product (Name, SKU, Barcode)..."
                    class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="px-4 py-2 bg-gray-50 overflow-x-auto whitespace-nowrap scrollbar-hide">
            <button wire:click="selectCategory(null)"
                class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 mr-2 border {{ is_null($selectedCategory) ? 'bg-blue-600 text-white border-blue-600 shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-100' }}">
                All Items
            </button>
            @foreach($categories as $category)
                <button wire:click="selectCategory({{ $category->id }})"
                    class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 mr-2 border {{ $selectedCategory == $category->id ? 'bg-blue-600 text-white border-blue-600 shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-100' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Product Grid -->
        <div class="flex-1 overflow-y-auto p-4">
            <div class="grid grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($products as $product)
                    <div wire:click="addToCart({{ $product->id }})"
                        class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer overflow-hidden border border-gray-100 group">
                        <div class="h-32 bg-gray-200 relative overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div
                                class="absolute top-2 right-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-md shadow-sm">
                                Stock: {{ $product->stock }}
                            </div>
                        </div>
                        <div class="p-3">
                            <h3 class="font-semibold text-gray-800 truncate" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            <p class="text-xs text-gray-500 mb-2">{{ $product->category->name }}</p>
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-blue-600">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                                <button
                                    class="p-1.5 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center h-64 text-gray-400">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <p class="text-lg">Product not found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Panel: Cart -->
    <div class="w-1/3 bg-white shadow-xl flex flex-col border-l border-gray-200 z-20">
        <div class="p-4 border-b border-gray-100 bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                Current Order
            </h2>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-3">
            @forelse($cart as $index => $item)
                <div
                    class="flex items-center justify-between p-3 bg-white border border-gray-100 rounded-lg shadow-sm hover:border-blue-200 transition-colors">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800 line-clamp-1">{{ $item['name'] }}</h4>
                        <p class="text-sm text-blue-600 font-semibold">Rp {{ number_format($item['price'], 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="flex items-center border rounded-lg overflow-hidden">
                            <button wire:click="updateQuantity({{ $index }}, -1)"
                                class="px-2 py-1 bg-gray-50 hover:bg-gray-200 transition-colors text-gray-600">-</button>
                            <span class="px-2 py-1 text-sm font-medium w-8 text-center">{{ $item['quantity'] }}</span>
                            <button wire:click="updateQuantity({{ $index }}, 1)"
                                class="px-2 py-1 bg-gray-50 hover:bg-gray-200 transition-colors text-gray-600">+</button>
                        </div>
                        <button wire:click="removeFromCart({{ $index }})"
                            class="text-red-400 hover:text-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                    <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <p>Cart is empty</p>
                </div>
            @endforelse
        </div>

        <div class="p-4 bg-gray-50 border-t border-gray-200">
            @if(session()->has('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Payment Method Selection -->
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Payment Method</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" wire:model.live="paymentMethod" value="cash" class="peer sr-only">
                        <div
                            class="text-center p-2 rounded-lg border border-gray-200 bg-white peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:bg-gray-50 transition-all">
                            <span class="text-sm font-semibold">Cash</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model.live="paymentMethod" value="qris" class="peer sr-only">
                        <div
                            class="text-center p-2 rounded-lg border border-gray-200 bg-white peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:bg-gray-50 transition-all">
                            <span class="text-sm font-semibold">QRIS</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-600">Subtotal</span>
                <span class="text-xl font-bold text-gray-900">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
            </div>

            <button wire:click="checkout" @if(empty($cart)) disabled @endif
                class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 font-bold text-lg flex items-center justify-center">
                <span>Checkout</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </button>
        </div>
    </div>
</div>