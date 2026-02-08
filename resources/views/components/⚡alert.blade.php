<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    @if(session('success') || session('error') || session('warning') || session('info'))
    @php
        $type = session('success') ? 'success' : (session('error') ? 'error' : (session('warning') ? 'warning' : 'info'));
        $message = session($type);

        $styles = [
            'success' => 'bg-green-50 border-green-400 text-green-800',
            'error'   => 'bg-red-50 border-red-400 text-red-800',
            'warning' => 'bg-yellow-50 border-yellow-400 text-yellow-800',
            'info'    => 'bg-blue-50 border-blue-400 text-blue-800',
        ][$type];
    @endphp

    <div class="p-4 mb-4 border-l-4 rounded shadow-sm {{ $styles }}" role="alert">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                {{-- Dynamic Icon based on type --}}
                @if($type == 'error')
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                @else
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                @endif
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">{{ $message }}</p>
            </div>
        </div>
    </div>
@endif

</div>
