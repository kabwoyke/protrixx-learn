<?php

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

new class extends Component
{
    //
    #[Validate('required')]
    public $email = '';
     #[Validate('required')]
    public $password = '';

    public function login(){
        $this->validate([
            'email' => 'required|email|string',
            'password' => 'required|string'
        ]);
        $user = User::where('email' , $this->email)->first();

       if (!$user || !Hash::check($this->password, $user->password)) {
        session()->flash('error', 'Invalid email or password.');
        return;
    }

    Auth::login($user, remember: true);

    return redirect()->intended("dash");


    }
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
            @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg flex items-center shadow-sm">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
        </svg>
        <p class="text-sm font-semibold">{{ session('error') }}</p>
    </div>
  @endif

  @if(session('status'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg flex items-center shadow-sm">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <p class="text-sm font-semibold">{{ session('status') }}</p>
    </div>
@endif
        <div class="bg-white px-8 py-10 shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100">
            <form class="space-y-5" wire:submit='login'>
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                    <input
                    wire:model='email'
                    id="email" name="email" type="email" required
                        class="mt-1 block w-full rounded-lg px-4 border-slate-200 py-2.5 text-slate-900 shadow-sm focus:border-[#1c7ed6] focus:ring-[#1c7ed6] sm:text-sm">

                        @error('email')
                             <span class="text-red-400 text-sm" >{{ $message }}</span>
                        @enderror

                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                        <a href="#" class="text-xs font-bold text-[#1c7ed6] hover:opacity-80">Forgot?</a>
                    </div>
                    <input wire:model='password' id="password" name="password" type="password" required
                        class="mt-1 block w-full rounded-lg px-4 border-slate-200 py-2.5 text-slate-900 shadow-sm focus:border-[#1c7ed6] focus:ring-[#1c7ed6] sm:text-sm">

                        @error('password')
                             <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
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
