<?php

use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state, layout, mount};

state(['path']);

layout('components.layouts.app');

mount(function () {
    $this->path = request()->path();
    $isAuth = Auth::check();

    if ($isAuth && in_array($this->path, ['sign-in'])) {
        $this->redirectRoute('stock', navigate: true);
    } elseif (!$isAuth && in_array($this->path, ['stock'])) {
        $this->redirectRoute('sign-in', navigate: true);
    }
})
?>

<div class="h-screen flex flex-col">
    @if($path == 'sign-in')
    <livewire:sign-in />
    @elseif(in_array($path,['stock']) )
    <livewire:nav-bar />
    <div class="flex justify-between grow">
        <div class="w-1/5 border-r-2 border-black/10">
            <livewire:side-bar />
        </div>
        @if($path == 'stock')
        <div class="w-4/5 bg-black/10 px-4 py-8">
            <livewire:stock />
        </div>
        @endif
    </div>
    @endif
</div>