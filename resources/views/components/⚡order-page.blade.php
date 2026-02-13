<?php

use Livewire\Component;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

new class extends Component
{
    //

    public $orderCount = 0;

    public function downloadInvoice($orderId)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['order_items.paper'])
            ->findOrFail($orderId);

        // This points to a blade file we will create in Step 3
        $pdf = Pdf::loadView('invoice.invoice', ['order' => $order]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "Protrixx-Invoice-{$order->id}.pdf");
    }

    public function render(){
         $orders = Order::where('status', 'COMPLETED')
          ->where('user_id', Auth::id())
        ->with('order_items')
        ->latest()
        ->paginate(2);

        // dd(Auth::id());

        $this->orderCount = count($orders);

        return $this->view([
            'orders' => $orders
    ]);
    }
};
?>

<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <div class="mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Successful Orders</h1>
                <p class="text-gray-600">Showing all completed transactions for your account.</p>
            </div>
            <span class="text-sm font-medium text-gray-500">{{ $orders->total() }} Orders Found</span>
        </div>

        <div class="space-y-6">
            @forelse($orders as $order)
                <div class="bg-white border-l-4 border-[#1669B3] rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                            <div>
                                <span class="text-xs text-gray-400 uppercase tracking-widest font-bold">Ref: {{ $order->checkout_request_id }}</span>
                                <p class="text-lg font-medium text-gray-900">Order #{{ $order->id }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            <div class="mt-2 sm:mt-0 text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-[#1669B3] uppercase tracking-tighter">
                                    <svg class="w-2 h-2 mr-2 fill-current" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                    {{ $order->status }}
                                </span>
                                <p class="mt-1 text-2xl font-black text-gray-900">KES {{ number_format($order->total_amount, 2) }}</p>
                            </div>
                        </div>

                       <div class="border-t border-gray-100 pt-4 mt-4">
    <h4 class="text-xs font-semibold text-gray-400 uppercase mb-2">Items Purchased</h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
        @foreach($order->order_items as $item)
            <div class="flex items-center text-sm text-gray-700 bg-gray-50 p-2 rounded group">
                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-white border border-gray-200 rounded text-[10px] mr-2 font-bold shadow-sm">
                    {{ $item->quantity }}x
                </span>

                <div class="flex-shrink-0 w-10 h-10 mr-3 bg-white border border-gray-200 rounded overflow-hidden">
                    @if($item->paper && $item->paper->preview_path)
                        <img src="https://yolo-tickets.sfo3.cdn.digitaloceanspaces.com/{{ $item->paper->preview_path }}"
                             alt="{{ $item->paper->title }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <span class="truncate font-medium">{{ $item->paper->title ?? 'Product Item' }}</span>
            </div>
        @endforeach
    </div>
</div>

                        <div class="mt-6 flex justify-end items-center space-x-4 border-t border-gray-100 pt-4">
                           <button
    wire:click="downloadInvoice({{ $order->id }})"
    wire:loading.attr="disabled"
    class="text-sm font-semibold text-gray-500 hover:text-[#1669B3] transition-colors disabled:opacity-50"
>
    <span wire:loading.remove wire:target="downloadInvoice({{ $order->id }})">
        Download Invoice
    </span>
    <span wire:loading wire:target="downloadInvoice({{ $order->id }})">
        Generating PDF...
    </span>
</button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-lg border-2 border-dashed border-gray-200">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No completed orders</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't made any successful purchases yet.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>

    </div>
</div>
