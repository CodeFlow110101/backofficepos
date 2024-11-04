<?php

use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state, mount, on};

state(['user']);

on(['reset-nav-bar-user' => function () {
    $this->user = Auth::user();
}]);

mount(function () {
    $this->user = Auth::user();
});

?>

<div class="flex justify-between items-center">
    <div class="w-1/5 border-b-2 border-r-2 border-black/10 text-amber-500 font-semibold text-2xl align-middle px-8 py-5">
        BackOffice POS
    </div>
    <div class="w-4/5 flex justify-end items-center gap-2 px-6 border-b-2 border-black/10 h-full">
        <div>
            <svg class="h-10 w-10 text-black/30" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </div>
        <div class="flex flex-col justify-around">
            <div class="font-bold capitalize text-black/80">{{$user->name}}</div>
            <div class="text-sm text-black/60">admin</div>
        </div>
    </div>
</div>