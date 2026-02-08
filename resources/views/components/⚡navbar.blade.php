<?php

use Livewire\Component;

new class extends Component
{
    //


};
?>

<div>
   <nav x-data="{ mobileMenuOpen: false }" class="bg-white border-b border-slate-100 sticky top-0 z-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between items-center">

            <div class="flex flex-shrink-0 items-center">
                <a href="/" class="text-xl font-extrabold tracking-tight text-slate-900">
                    Protrixx <span class="text-[#1c7ed6]">Learn</span>
                </a>
            </div>

            <div class="hidden md:flex md:space-x-8">
                <a href="{{ route('browse_papers') }}" wire:navigate class="inline-flex items-center px-1 pt-1 text-sm font-medium  text-slate-500 ">Browse Papers</a>
                <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-slate-500 hover:text-slate-700 hover:border-slate-300 border-b-2 border-transparent transition">Past Papers</a>
                <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-slate-500 hover:text-slate-700 hover:border-slate-300 border-b-2 border-transparent transition">Study Notes</a>
            </div>

            <div class="hidden md:flex md:items-center md:space-x-4">
                <a href="{{ route('login_page') }}" wire:navigate  class="text-sm font-semibold text-slate-600 hover:text-slate-900">Log in</a>
                <a href="{{ route('signup_page') }}" wire:navigate   class="rounded-lg bg-[#1c7ed6] px-4 py-2 text-sm font-bold text-white shadow-md shadow-[#1c7ed6]/20 hover:bg-[#1669b3] transition">
                    Get Started
                </a>
            </div>

            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center rounded-md p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-500">
                    <span class="sr-only">Open main menu</span>
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden bg-white border-t border-slate-100">
        <div class="space-y-1 pb-3 pt-2">
            <a href="#" class="block border-l-4  bg-blue-50 py-2 pl-3 pr-4 text-base font-medium ">Dashboard</a>
            <a href="#" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-slate-500 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-700">Past Papers</a>
            <a href="#" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-slate-500 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-700">Study Notes</a>
        </div>
        <div class="border-t border-slate-100 pb-3 pt-4 px-4 space-y-2">
            <a href="{{ route('login_page') }}" wire:navigate class="block w-full text-center py-2 text-base font-medium text-slate-500 hover:text-slate-900">Log in</a>
            <a href="{{ route('signup_page') }}" wire:navigate   class="block w-full text-center rounded-lg bg-[#1c7ed6] py-2 text-base font-bold text-white shadow-lg">Get Started</a>
        </div>
    </div>
</nav>
</div>
