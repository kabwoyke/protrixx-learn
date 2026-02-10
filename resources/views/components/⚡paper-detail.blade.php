<?php

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Paper;

new class extends Component
{
    //

    public $paper;

    public function red(){
            $fr = "Hello";
    }

   public function addToCart($productId)
{
    // 1. Get current cart
    $cart = session()->get('cart', []);

    // dd($cart);

    // 2. Check if item exists in session
    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += 1;
    } else {
        // 3. Find the paper in the DB
        $papers = Paper::find($productId);

        // Safety check: ensure the paper actually exists
        if (!$papers) {
            return; // Or show an error message
        }

        $cart[$productId] = [
            'title' => $papers->title,
            'quantity' => 1,
            'price' => $papers->price,
            'image' => $papers->preview_path // Useful for the checkout page later
        ];
    }

    // 4. IMPORTANT: Save the updated cart back to the session
    session()->put('cart', $cart);
    // dd($cart);
    // 5. Update UI (Livewire event)
    // 5. Calculate total quantity across all items
    $totalQuantity = collect($cart)->sum('quantity');

// 6. Update UI (Livewire event) with the sum
    $this->dispatch('cart-updated', count: $totalQuantity);
    // $this->dispatch('cart-updated', count: count($cart));
}



public function mount()
    {

        // Fetch the paper once using the ID from the URL
        $this->paper = Paper::with(['category', 'grade_level'])->findOrFail(request()->route('id'));
    }

    public function render(){

        // $paper = Paper::where('id' , request()->route('id'))->first();

        return $this->view();
    }
};
?>

<div>


   <div class="min-h-screen bg-white font-sans flex flex-col md:flex-row">
    
    <!-- Left Side: Paper Preview Section (Scrollable) -->
    <div class="flex-1 bg-gray-100 flex items-center justify-center p-4 sm:p-12 overflow-y-auto">
        <div class="max-w-3xl w-full bg-white shadow-2xl rounded-sm ring-1 ring-gray-200">
            <!-- Full Height Preview Image -->
            <img 
                src="https://yolo-tickets.sfo3.cdn.digitaloceanspaces.com/{{ $paper->preview_path }}" 
                alt="Document Preview" 
                class="w-full h-auto min-h-[80vh] object-contain p-2"
            >
        </div>
    </div>

    <!-- Right Side: Details Sidebar (Fixed on Desktop) -->
    <div class="w-full md:w-[400px] lg:w-[450px] border-l border-gray-200 bg-white flex flex-col h-screen overflow-y-auto">
        
        <!-- Navigation & Breadcrumb -->
        <div class="p-6 border-b border-gray-100">
            <a href="#" class="text-sm font-semibold text-[#1669B3] hover:text-[#125896] flex items-center transition">
                <svg xmlns="http://www.w3.org" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>

        <div class="p-8 flex-grow">
            <!-- Badges -->
            <div class="flex flex-wrap gap-2 mb-6">
                <span class="px-3 py-1 bg-blue-50 text-[#1669B3] text-xs font-bold uppercase tracking-widest rounded-full">
                    {{ $paper->category->name ?? 'General' }}
                </span>
                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold uppercase tracking-widest rounded-full">
                    Year: {{ $paper->year }}
                </span>
            </div>

            <!-- Title & Metadata -->
            <h1 class="text-3xl font-extrabold text-gray-900 leading-tight mb-4">{{ $paper->title }}</h1>
            
            <div class="space-y-6">
                <!-- Data Points Grid -->
                <div class="grid grid-cols-2 gap-6 py-6 border-y border-gray-100">
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase mb-1">Grade Level</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $paper->grade_level->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase mb-1">File Type</p>
                        <p class="text-lg font-semibold text-gray-800">PDF Document</p>
                    </div>
                </div>

                <!-- Price and CTA -->
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-gray-500 font-medium">Full Access Price</span>
                        <span class="text-3xl font-black text-gray-900 tracking-tighter">KES {{ number_format($paper->price) }}</span>
                    </div>
                    
                    <div class="space-y-3">
                        <button wire:click='addToCart({{ $paper->id }})'  class="w-full py-4 bg-[#1669B3] text-white font-bold rounded-xl text-lg hover:bg-[#125896] transform active:scale-[0.98] transition-all shadow-lg shadow-blue-200">
                            Add To Cart
                        </button>
                        {{-- <button class="w-full py-3 bg-white border-2 border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition">
                            Save to Library
                        </button> --}}
                    </div>
                </div>

                <!-- Abstract / Info -->
                <div>
                    <h3 class="font-bold text-gray-900 mb-3 uppercase text-xs tracking-widest">About this Paper</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        This academic resource provides a comprehensive analysis for {{ $paper->grade_level->name }} students. It covers key concepts related to {{ $paper->category->name ?? 'the subject' }} with detailed explanations and practice examples.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Footer Info -->
        <div class="p-8 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400 font-medium">Verified by PaperLibrary Compliance Team</p>
        </div>
    </div>
</div>

</div>