<?php

use Livewire\Component;
use App\Models\Paper;

new class extends Component
{
    //

    public $search = '';

   public function addToCart($productId)
{
    // 1. Get current cart
    $cart = session()->get('cart', []);

    // 2. Check if item exists in session
    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += 1;
    } else {
        // 3. Find the paper in the DB
        $paper = Paper::find($productId);

        // Safety check: ensure the paper actually exists
        if (!$paper) {
            return; // Or show an error message
        }

        $cart[$productId] = [
            'title' => $paper->title,
            'quantity' => 1,
            'price' => $paper->price,
            'image' => $paper->preview_path // Useful for the checkout page later
        ];
    }

    // 4. IMPORTANT: Save the updated cart back to the session
    session()->put('cart', $cart);
    // dd($cart);
    // 5. Update UI (Livewire event)
    $this->dispatch('cart-updated', count: count($cart));
}

    public function render(){

         $papers = Paper::with(['grade_level' , 'category'])
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('year', 'like', '%' . $this->search . '%')
                      ->orWhereHas('grade_level', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->latest()
            ->paginate(12); // Use paginate instead of get() for your UI

         return $this->view(['papers' => $papers]);

    }

};
?>

<div>

   <div class="min-h-screen bg-gray-50 font-sans">
    <!-- Navbar Placeholder -->


    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Search Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Browse Academic Papers</h1>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Access a wide range of verified research papers, past exams, and study guides.</p>

            <div class="relative max-w-2xl mx-auto group">
                <input
                    wire:model.live='search'
                    type="text"
                    placeholder="Search by title, year, or category..."
                    class="w-full pl-14 pr-6 py-4 bg-white rounded-2xl border border-gray-200 shadow-sm focus:ring-2 focus:ring-[#1669B3] focus:border-[#1669B3] outline-none transition-all duration-300 group-hover:shadow-md"
                >
                <div class="absolute left-5 top-4.5 text-gray-400">
                    <svg xmlns="http://www.w3.org" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Filters & Results Info -->
        <div class="flex justify-between items-center mb-8 border-b border-gray-200 pb-4">
            <span class="text-gray-500 font-medium italic">Showing {{ count($papers) }} results</span>
            <div class="flex space-x-3">
                <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium hover:bg-gray-50 transition">Filter</button>
                <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium hover:bg-gray-50 transition">Sort: Newest</button>
            </div>
        </div>

        <!-- Papers Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <!-- Paper Card Example -->

            @if (count($papers) <= 0)

             <div class="col-span-full flex flex-col items-center justify-center py-20 px-4 bg-white rounded-3xl border-2 border-dashed border-gray-200">
        <div class="bg-blue-50 p-6 rounded-full mb-6">
            <svg xmlns="http://www.w3.org" class="h-16 w-16 text-[#1669B3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No papers found</h3>
        <p class="text-gray-500 text-center max-w-sm mb-8">
            We couldn't find any papers matching <span class="font-semibold text-gray-800">"{{ $search }}"</span>. Try checking your spelling or using different keywords.
        </p>

        @if($search)
            <button
                wire:click="$set('search', '')"
                class="inline-flex items-center px-6 py-3 bg-[#1669B3] text-white font-bold rounded-xl hover:bg-[#125896] transition shadow-md"
            >
                <svg xmlns="http://www.w3.org" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Clear Search
            </button>
        @endif
    </div>
            @endif

            @foreach ( $papers as $paper )

            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                <!-- Preview Placeholder -->
                <div class="h-48 bg-gray-100 rounded-t-2xl flex items-center justify-center overflow-hidden">
                    <img src="https://yolo-tickets.sfo3.cdn.digitaloceanspaces.com/{{ $paper->preview_path}}" alt="Paper Preview" class="group-hover:scale-105 transition-transform duration-500 object-cover">
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#1669B3] bg-blue-50 px-2 py-1 rounded">{{ $paper->category->name }}</span>
                        <span class="text-xs text-gray-400 font-semibold">{{ $paper->year }}</span>
                    </div>

                    <h2 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $paper->title }}</h2>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3 italic">A comprehensive study on classroom integration...</p>

                    <div class="mt-auto space-y-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600 font-medium">Grade: <span class="text-gray-900">{{ $paper->grade_level->name }}</span></span>
                            <span class="text-lg font-bold text-gray-900">KES {{ $paper->price }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('detail_page' , ['id' => $paper->id]) }}" wire:navigate class="w-full py-2 border border-[#1669B3] text-[#1669B3] font-semibold rounded-lg text-sm hover:bg-blue-50 transition inline-flex items-center justify-center">
                            Preview
                        </a>
                            <button wire:click='addToCart({{ $paper->id }})' class="w-full py-2 bg-[#1669B3] text-white font-semibold rounded-lg text-sm hover:bg-[#125896] transition shadow-sm">Add To Cart</button>
                        </div>
                    </div>
                </div>
            </div>
             @endforeach
            <!-- Repeat Card for more items... -->
        </div>
    </main>
</div>

</div>
