<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class PosPage extends Component
{
    #[Title('POS Dashboard')]
    #[Layout('components.layouts.app')]

    public $search = '';
    public $otp_search = '';
    public $selectedCategory = null;
    public $cart = [];
    public $paymentMethod = 'cash'; // Default 'cash'

    // Calculated properties
    public function getTotalProperty()
    {
        return collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function updatedSearch()
    {
        // React to search updates if needed
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId === $this->selectedCategory ? null : $categoryId;
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product)
            return;

        $existingItemKey = null;
        foreach ($this->cart as $key => $item) {
            if ($item['id'] == $productId) {
                $existingItemKey = $key;
                break;
            }
        }

        if ($existingItemKey !== null) {
            $this->cart[$existingItemKey]['quantity']++;
        } else {
            $this->cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }

        $this->saveCart();
    }

    public function updateQuantity($index, $change)
    {
        if (!isset($this->cart[$index]))
            return;

        $this->cart[$index]['quantity'] += $change;

        if ($this->cart[$index]['quantity'] <= 0) {
            unset($this->cart[$index]);
            $this->cart = array_values($this->cart); // Reindex
        }

        $this->saveCart();
    }

    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
        $this->saveCart();
    }

    public function clearCart()
    {
        $this->cart = [];
        $this->saveCart();
    }

    protected function saveCart()
    {
        session()->put('cart', $this->cart);
    }

    public function checkout()
    {
        if (empty($this->cart))
            return;

        // Create Transaction
        $transaction = Transaction::create([
            'invoice_code' => 'INV-' . time(),
            'total_amount' => $this->total,
            'cash_received' => $this->total, // Auto-pay for now, or add modal later
            'change_amount' => 0,
            'payment_method' => $this->paymentMethod,
            'status' => 'completed',
        ]);

        foreach ($this->cart as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Decrement Stock
            Product::where('id', $item['id'])->decrement('stock', $item['quantity']);
        }

        $this->clearCart();

        // session()->flash('success', 'Transaction successful! Invoice: ' . $transaction->invoice_code);

        // Redirect to invoice print
        return redirect()->route('invoice.print', ['invoiceCode' => $transaction->invoice_code]);
    }

    public function render()
    {
        $categories = Category::all();

        $products = Product::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%')
                    ->orWhere('barcode', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCategory, function ($q) {
                $q->where('category_id', $this->selectedCategory);
            })
            ->get();

        return view('livewire.pos-page', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
