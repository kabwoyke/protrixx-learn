<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <div class="flex min-h-screen flex-col justify-center px-6 py-12 lg:px-8 bg-slate-50">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="text-center text-3xl font-extrabold tracking-tight text-slate-900">
            Protrixx <span class="text-[#1c7ed6]">Learn</span>
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Log in to access your past papers & notes
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white px-8 py-10 shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100">
            <form class="space-y-5" action="#" method="POST">
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                    <input id="email" name="email" type="email" required
                        class="mt-1 block w-full rounded-lg px-4 border-slate-200 py-2.5 text-slate-900 shadow-sm focus:border-[#1c7ed6] focus:ring-[#1c7ed6] sm:text-sm">
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                        <a href="#" class="text-xs font-bold text-[#1c7ed6] hover:opacity-80">Forgot?</a>
                    </div>
                    <input id="password" name="password" type="password" required
                        class="mt-1 block w-full rounded-lg px-4 border-slate-200 py-2.5 text-slate-900 shadow-sm focus:border-[#1c7ed6] focus:ring-[#1c7ed6] sm:text-sm">
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-[#1c7ed6] focus:ring-[#1c7ed6]">
                    <label for="remember" class="ml-2 block text-sm text-slate-600">Remember me</label>
                </div>

                <button type="submit"
                    class="flex w-full justify-center rounded-lg bg-[#1c7ed6] px-4 py-3 text-sm font-bold text-white shadow-lg shadow-[#1c7ed6]/30 hover:bg-[#1669b3] transition-all focus:outline-none focus:ring-2 focus:ring-[#1c7ed6] focus:ring-offset-2">
                    Sign In
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500">
                    New to Protrixx?
                    <a href="{{ route('signup_page') }}" wire:navigate class="font-bold text-[#1c7ed6] hover:underline">Create an account</a>
                </p>
            </div>
        </div>
    </div>
</div>
</div>
