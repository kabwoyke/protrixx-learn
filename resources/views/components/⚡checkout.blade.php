<?php

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

new class extends Component {
    //

    public $email;
    public $fullName;
    public $statusMessage = '';
    public $phoneNumber; // Format: 2547XXXXXXXX

    public function getCartProperty()
    {
        return session()->get('cart', []);
    }

    public function getTotal()
    {
        return array_reduce(
            $this->cart,
            function ($carry, $item) {
                return $carry + $item['price'] * $item['quantity'];
            },
            0,
        );
    }

    public function processCheckout()
    {
        $this->validate([
            'email' => 'required|email',
            'fullName' => 'required|min:3',
            'phoneNumber' => 'required',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return;
        }

        //  dd($this->phoneNumber);
        $passkey = env('PASSKEY');
        $short_code = env('SHORTCODE');
        $timestamp = Carbon::now()->format('YmdHis');
        $password = base64_encode($short_code . $passkey . $timestamp);
        $amount = $this->getTotal();

        $token = Cache::remember('mpesa_access_token', 3600, function () {
            $consumer_key = env('CONSUMER_KEY');
            $consumer_secret = env('CONSUMER_SECRET');
            $auth_key = base64_encode($consumer_key . ':' . $consumer_secret);

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $auth_key,
            ])->get('https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

            return $response->json('access_token');
        });

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
            'BusinessShortCode' => $short_code,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $this->phoneNumber,
            'PartyB' => $short_code,
            'PhoneNumber' => $this->phoneNumber,
            'CallBackURL' => 'https://a460-102-204-4-12.ngrok-free.app/callback',
            'AccountReference' => 'Protrixx-Learn',
            'TransactionDesc' => 'Ticket Payment',
        ]);

        $responseData = $response->json();

        if ($response->failed()) {
            return back()->withErrors(['mpesa' => $responseData['errorMessage'] ?? 'Unknown error']);
        }

        DB::transaction(function () use ($cart , $responseData) {
            // 1. Create the Main Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $this->getTotal(),
                'status' => 'PENDING',
                'checkout_request_id' => $responseData['CheckoutRequestID']
            ]);

            // 2. Create the Order Items
            foreach ($cart as $paperId => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'paper_id' => $paperId,
                    'price' => $details['price'],
                    'quantity' => $details['quantity'],
                ]);
            }

            // 3. Notify user that a prompt has been sent to their phone
            $this->statusMessage = 'Check your phone for the M-Pesa PIN prompt!';
            // $this->dispatch('notify', message: 'Check your phone for the M-Pesa PIN prompt!');
        });
    }
};
?>

<div>

    <div x-data="{ show: false }" x-init="$watch('$wire.statusMessage', value => {
        if (value) {
            show = true;
            setTimeout(() => show = false, 10000)
        }
    })" x-show="show" x-cloak
        class="fixed top-24 right-6 z-50 max-w-sm w-full bg-white border border-slate-100 rounded-2xl shadow-2xl p-4 flex items-center space-x-4"
        x-transition:enter="transition ease-out duration-500" x-transition:enter-start="translate-x-full opacity-0"
        x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0">
        <div
            class="bg-green-500 h-10 w-10 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg shadow-green-100">
            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-bold text-slate-900" x-text="$wire.statusMessage"></p>
            <p class="text-[10px] text-slate-400 uppercase font-bold tracking-tighter">Enter M-Pesa PIN now</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <div class="lg:col-span-7">
                <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Checkout</h1>

                <form wire:submit.prevent="processCheckout" class="space-y-8">
                    <section>
                        <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                            <span
                                class="bg-slate-900 text-white w-6 h-6 rounded-full inline-flex items-center justify-center text-xs mr-2">1</span>
                            Contact Information
                        </h2>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Full Name</label>
                                <input type="text" wire:model="fullName"
                                    class="mt-1 block w-full rounded-lg border-slate-200 shadow-sm focus:border-[#1c7ed6] focus:ring-[#1c7ed6]">
                                @error('fullName')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Email Address (For
                                    Delivery)</label>
                                <input type="email" wire:model="email"
                                    class="mt-1 block w-full rounded-lg border-slate-200 shadow-sm focus:border-[#1c7ed6] focus:ring-[#1c7ed6]">
                                <p class="mt-1 text-xs text-slate-500">The study papers will be sent to this email.</p>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                            <span
                                class="bg-slate-900 text-white w-6 h-6 rounded-full inline-flex items-center justify-center text-xs mr-2">2</span>
                            Payment via M-Pesa
                        </h2>
                        <div class="border-2 border-[#1c7ed6] rounded-xl p-6 bg-blue-50/30">
                            <div class="flex items-center mb-4">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/15/M-PESA_LOGO-01.svg/512px-M-PESA_LOGO-01.svg.png"
                                    alt="M-Pesa" class="h-8">
                                <span class="ml-3 font-bold text-slate-700">Lipa na M-Pesa Online</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">M-Pesa Phone Number</label>
                                <div class="relative mt-1">
                                    <input type="text" wire:model="phoneNumber" placeholder="254712345678"
                                        class="block w-full rounded-lg border-slate-200 pl-3 pr-10 focus:border-[#1c7ed6] focus:ring-[#1c7ed6] shadow-sm">
                                </div>
                                @error('phoneNumber')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                                <p class="mt-2 text-xs text-slate-500 italic">
                                    You will receive an STK Push prompt on this phone to enter your PIN.
                                </p>
                            </div>
                        </div>
                    </section>
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full bg-[#1c7ed6] text-white py-4 rounded-xl font-bold text-lg shadow-xl shadow-blue-200 hover:bg-[#1669b3] transition flex items-center justify-center space-x-3 disabled:opacity-70 disabled:cursor-not-allowed">

                        <svg wire:loading wire:target="processCheckout" class="animate-spin h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>

                        <span wire:loading.remove wire:target="processCheckout">
                            Complete Purchase (KES {{ number_format($this->getTotal(), 2) }})
                        </span>

                        <span wire:loading wire:target="processCheckout">
                            Sending M-Pesa Prompt...
                        </span>
                    </button>
                </form>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden sticky top-24">
                    <div class="p-6 bg-slate-50 border-b border-slate-200">
                        <h2 class="font-bold text-slate-900">Order Summary</h2>
                    </div>

                    <ul class="divide-y divide-slate-100 px-6 overflow-y-auto max-h-96">
                        @foreach ($this->cart as $item)
                            <li class="py-4 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="bg-blue-50 text-[#1c7ed6] p-2 rounded mr-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 line-clamp-1">{{ $item['title'] }}
                                        </p>
                                        <p class="text-xs text-slate-500">Qty: {{ $item['quantity'] }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold text-slate-900">
                                    KES {{ number_format($item['price'] * $item['quantity'], 2) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="p-6 bg-slate-50 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Subtotal</span>
                            <span class="font-medium text-slate-900">KES
                                {{ number_format($this->getTotal(), 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg pt-2 border-t border-slate-200">
                            <span class="font-bold text-slate-900">Total</span>
                            <span class="font-black text-[#1c7ed6]">KES {{ number_format($this->getTotal(), 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-center space-x-6 text-slate-400">
                    <div class="flex items-center text-xs">
                        <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                        Instant Delivery
                    </div>
                    <div class="flex items-center text-xs">
                        <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Secure SSL
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
