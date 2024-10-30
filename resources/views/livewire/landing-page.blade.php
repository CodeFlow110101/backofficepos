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

<div>
    @if($path == 'sign-in')
    <livewire:sign-in />
    @elseif($path == 'stock')
    <livewire:stock />
    @endif
</div>