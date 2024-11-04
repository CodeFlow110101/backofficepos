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
    } elseif (!$isAuth && in_array($this->path, ['stock', 'setting', 'warehouse','add-edit-warehouse'])) {
        $this->redirectRoute('sign-in', navigate: true);
    }
})
?>

<div class="h-screen flex flex-col">
    @if($path == 'sign-in')
    <livewire:sign-in />
    @elseif(in_array($path,['stock','setting','warehouse','add-edit-warehouse']) )
    <livewire:nav-bar />
    <div class="flex justify-between grow">
        <div class="w-1/5 border-r-2 border-black/10">
            <livewire:side-bar />
        </div>
        <div class="w-4/5 h-full bg-black/10 px-4 py-8">
            @if($path == 'stock')
            <livewire:stock />
            @elseif($path == 'setting')
            <livewire:setting.setting />
            @elseif($path == 'warehouse')
            <livewire:warehouse.warehouse />
            @elseif($path == 'add-edit-warehouse')
            <livewire:warehouse.add-edit-warehouse />
            @endif
        </div>
    </div>
    @endif
</div>