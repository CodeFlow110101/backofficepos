<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state, mount};

state(['path']);

$signOut = function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    $this->redirectRoute('sign-in', navigate: true);
};

mount(function () {
    $this->path = request()->path();
});

?>

<div class="py-12 px-6 h-full flex flex-col justify-content-between">
    <div class="h-min grid grid-cols-1 gap-4">
        <a href="/warehouse" wire:navigate class="flex justify-start gap-2 items-center font-medium p-2 @if(in_array($path , ['warehouse' , 'manage-warehouse'])) bg-amber-500 @else text-black/70 hover:bg-amber-500 transition-colors duration-200 @endif rounded-lg group">
            <div>
                <svg class="w-5 h-5 @if(in_array($path , ['warehouse' , 'manage-warehouse'])) text-white @else text-black/70 group-hover:text-white transition-colors duration-200 @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                </svg>
            </div>
            <div class="@if(in_array($path ,['warehouse' , 'manage-warehouse'])) text-white @else group-hover:text-white transition-colors duration-200 @endif">Warehouse</div>
        </a>
        <a href="/inventory" wire:navigate class="flex justify-start gap-2 items-center font-medium p-2 @if(in_array($path ,['inventory' , 'manage-inventory'])) bg-amber-500 @else text-black/70 hover:bg-amber-500 transition-colors duration-200 @endif rounded-lg group">
            <div>
                <svg class="w-5 h-5 @if(in_array($path ,['inventory' , 'manage-inventory'])) text-white @else text-black/70 group-hover:text-white transition-colors duration-200 @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                </svg>
            </div>
            <div class="@if(in_array($path ,['inventory' , 'manage-inventory'])) text-white @else group-hover:text-white transition-colors duration-200 @endif">Inventory</div>
        </a>
        <a href="/stock" wire:navigate class="flex justify-start gap-2 items-center font-medium p-2 @if($path == 'stock') bg-amber-500 @else text-black/70 hover:bg-amber-500 transition-colors duration-200 @endif rounded-lg group">
            <div>
                <svg class="w-5 h-5 @if($path == 'stock') text-white @else text-black/70 group-hover:text-white transition-colors duration-200 @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z" />
                </svg>
            </div>
            <div class="@if($path == 'stock') text-white @else group-hover:text-white transition-colors duration-200 @endif">Stock</div>
        </a>
        <div class="flex justify-start gap-2 items-center hover:bg-amber-500 p-2 transition-colors duration-200 rounded-lg group">
            <div>
                <svg class="w-5 h-5 text-black/70 group-hover:text-white transition-colors duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                </svg>
            </div>
            <div class="group-hover:text-white transition-colors duration-200">Delivery</div>
        </div>
        <div class="flex justify-start gap-2 items-center hover:bg-amber-500 p-2 transition-colors duration-200 rounded-lg group">
            <div>
                <svg class="w-5 h-5 text-black/70 group-hover:text-white transition-colors duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                </svg>
            </div>
            <div class="group-hover:text-white transition-colors duration-200">Sales</div>
        </div>
    </div>

    <div class="mt-auto">
        <div class="h-min grid grid-cols-1 gap-4">
            <a href="/setting" wire:navigate class="flex justify-start gap-2 items-center font-medium p-2 @if($path == 'setting') bg-amber-500 @else text-black/70 hover:bg-amber-500 transition-colors duration-200 @endif rounded-lg group">
                <div>
                    <svg class="w-5 h-5 @if($path == 'setting') text-white @else text-black/70 group-hover:text-white transition-colors duration-200 @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>
                </div>
                <div class="@if($path == 'setting') text-white @else group-hover:text-white transition-colors duration-200 @endif">Settings</div>
            </a>

            <div wire:click="signOut" class="flex justify-start gap-2 items-center hover:bg-amber-500 p-2 transition-colors duration-200 rounded-lg group cursor-pointer">
                <div>
                    <svg class="w-5 h-5 text-black/70 group-hover:text-white transition-colors duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                    </svg>
                </div>
                <div class="group-hover:text-white transition-colors duration-200">Sign Out</div>
            </div>
        </div>
    </div>
</div>