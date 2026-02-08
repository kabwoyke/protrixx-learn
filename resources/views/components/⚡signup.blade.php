<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

new class extends Component
{
    //

    #[Validate('required')]
    public $phone_number = '';
    #[Validate('required')]
    public $email = '';
     #[Validate('required')]
    public $password = '';
     #[Validate('required|same:password')]
    public $password_confirmation = '';

    public $loading = false;
    public $error_message = '';

    public function signup(){

        $this->loading = true;
        $user = User::where('email' , $this->email)->first();

        if($user){
            return redirect()->back()
        ->with('error', 'An account with this email already exists.')
        ->withInput();
        }

        $hashedPassword = Hash::make($this->password);

        User::create([
            'email' => $this->email,
            'password' => $hashedPassword,
            'phone_number' => $this->phone_number
        ]);

         $this->loading = false;

        return redirect()->to('/auth/login')->with('status', 'Your account has been created! Please log in.');


    }
};
?>

<div class="max-w-md mx-auto px-6 py-10">


  <div class="text-center mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Join Protrixx Learn</h1>
    <p class="text-gray-600">Get instant access to top-tier exam resources</p>
  </div>

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg flex items-center shadow-sm">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
        </svg>
        <p class="text-sm font-semibold">{{ session('error') }}</p>
    </div>
  @endif

  <form class="space-y-5" wire:submit='signup'>
    <div>
      <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
        Phone Number
      </label>
      <input
      wire:model='phone_number'
        type="tel"
        id="phone"
        name="phone_number"
        placeholder="+254 700 000 000"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1c7ed6] focus:border-[#1c7ed6] outline-none transition"
        required
      >
      @error('phone_number')
        <span class="text-red-400 text-sm" >{{ $message }}</span>
      @enderror
    </div>

    <div>
      <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
        Email Address
      </label>
      <input
        wire:model.live='email'
        type="email"
        id="email"
        name="email"
        placeholder="Enter your email"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1c7ed6] focus:border-[#1c7ed6] outline-none transition"

      >

      @error('email')

      <span class="text-red-400 text-sm">{{ $message }}</span>

      @enderror
    </div>

    <div>
      <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
        Password
      </label>
      <input
        wire:model.live='password'
        type="password"
        id="password"
        name="password"
        placeholder="Create a strong password"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1c7ed6] focus:border-[#1c7ed6] outline-none transition"
        required
      >


    </div>

    <div>
      <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-2">
        Confirm Password
      </label>
      <input
      wire:model.live='password_confirmation'
        type="password"
        id="confirm-password"
        name="password_confirmation"
        placeholder="Re-enter your password"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1c7ed6] focus:border-[#1c7ed6] outline-none transition"
        required
      >
    </div>

    <div class="flex items-start gap-2 pt-1">
      <input
        type="checkbox"
        id="terms"
        name="terms"
        class="w-4 h-4 mt-0.5 text-[#1c7ed6] border-gray-300 rounded focus:ring-2 focus:ring-[#1c7ed6]"
        required
      >
      <label for="terms" class="text-sm text-gray-600">
        I agree to the <a href="/terms" class="text-[#1c7ed6] font-medium hover:underline">Terms & Conditions</a>
      </label>
    </div>

    <button
      type="submit"

      class="w-full bg-[#1c7ed6] text-white font-semibold py-3.5 rounded-lg hover:bg-[#1971c2] transform hover:-translate-y-0.5 transition-all shadow-md hover:shadow-lg"
    >
    <span wire:loading wire:target='signup' >Loading</span>
      <span wire:loading.remove wire:target='signup' >Create Free Account</span>
    </button>

    <div class="text-center pt-6 border-t border-gray-200">
      <p class="text-sm text-gray-600">
        Already have an account?
        <a href="{{ route("login_page") }}" wire:navigate class="text-[#1c7ed6] font-medium hover:underline ml-1">Sign in instead</a>
      </p>
    </div>
  </form>
</div>
