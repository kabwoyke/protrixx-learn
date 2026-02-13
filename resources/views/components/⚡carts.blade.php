<?php

use Livewire\Component;

new class extends Component
{
    //

    public function getCartProperty()
    {
        return session()->get('cart', []);
    }

    public function increment($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            $this->dispatch('cart-updated', count: count($cart));
        }
    }

    public function decrement($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id]) && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
            session()->put('cart', $cart);
        } else {
            $this->removeItem($id);
        }
        $this->dispatch('cart-updated', count: count(session()->get('cart', [])));
    }

 public function removeItem($id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    // Calculate the new total sum of remaining items
    $totalQuantity = collect($cart)->sum('quantity');

    // Dispatch the sum to the navbar
    $this->dispatch('cart-updated', count: $totalQuantity);
}

    public function getTotal()
    {
        return array_reduce($this->cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }
};
?>

<div>
    <div class="max-w-5xl mt-20 mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Shopping Cart</h1>

    @if(count($this->cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8">
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                    <ul class="divide-y divide-slate-200">
                        @foreach($this->cart as $id => $item)
                            <li class="p-6 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="h-16 w-12 bg-slate-100 rounded flex-shrink-0 flex items-center justify-center text-slate-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-slate-900">{{ $item['title'] }}</h3>
                                        <p class="text-sm text-slate-500">KES {{ number_format($item['price'], 2) }} each</p>
                                        <button wire:click="removeItem({{ $id }})" class="text-xs text-red-500 hover:text-red-700 font-medium mt-1">Remove</button>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center border border-slate-200 rounded-lg">
                                        <button wire:click="decrement({{ $id }})" class="px-3 py-1 hover:bg-slate-50 text-slate-600">-</button>
                                        <span class="px-3 py-1 text-sm font-semibold border-x border-slate-200">{{ $item['quantity'] }}</span>
                                        <button wire:click="increment({{ $id }})" class="px-3 py-1 hover:bg-slate-50 text-slate-600">+</button>
                                    </div>
                                    <div class="text-right min-w-[80px]">
                                        <span class="text-sm font-bold text-slate-900">KES {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="lg:col-span-4">
                <div class="bg-slate-50 rounded-xl p-6 border border-slate-200 sticky top-24">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Order Summary</h2>
                    <div class="space-y-3 pb-4 border-b border-slate-200">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span>KES {{ number_format($this->getTotal(), 2) }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Tax</span>
                            <span>KES 0.00</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-4 mb-6">
                        <span class="text-base font-bold text-slate-900">Total</span>
                        <span class="text-2xl font-black text-[#1c7ed6]">KES {{ number_format($this->getTotal(), 2) }}</span>
                    </div>
                   <a href="{{ route("checkout") }}"
                    wire:navigate
   class="block w-full text-center bg-[#1c7ed6] text-white py-3 rounded-lg font-bold shadow-lg shadow-blue-200 hover:bg-[#1669b3] transition duration-200">
    Proceed to Checkout
</a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-20 bg-white border border-dashed border-slate-300 rounded-2xl">
            <div class="mb-4 text-slate-300 flex justify-center">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h2 class="text-xl font-bold text-slate-900">Your cart is empty</h2>
            <p class="text-slate-500 mb-6">Looks like you haven't added any study materials yet.</p>
            <a href="{{ route('browse_papers') }}" wire:navigate class="inline-flex items-center px-6 py-2 bg-slate-900 text-white rounded-lg font-semibold hover:bg-slate-800 transition">
                Browse Papers
            </a>
        </div>
    @endif
</div>
</div>
