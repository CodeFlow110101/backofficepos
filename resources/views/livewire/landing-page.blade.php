<?php

use App\Models\Delivery;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state, layout, mount};

state(['path', 'id', 'url']);

layout('components.layouts.app');

mount(function () {
    $this->path = request()->path();
    $this->url = request()->url();
    $isAuth = Auth::check();

    if (str_contains($this->path, 'delivery-preview/') && Delivery::where('id', str_replace('delivery-preview/', '', $this->path))->exists()) {
        $this->id = str_replace('delivery-preview/', '', $this->path);
        $this->path = 'delivery-preview';
    } elseif (str_contains($this->path, 'delivery-preview/') && Delivery::where('id', str_replace('delivery-preview/', '', $this->path))->doesntExist()) {
        abort(404);
    }

    if ($isAuth && in_array($this->path, ['sign-in'])) {
        $this->redirectRoute('stock', navigate: true);
    } elseif (!$isAuth && in_array($this->path, ['stock', 'manage-stock', 'setting', 'warehouse', 'manage-warehouse', 'inventory', 'manage-inventory', 'delivery', 'manage-delivery', 'user', 'manage-user', 'manage-quantity', 'sale', 'manage-sale'])) {
        $this->redirectRoute('sign-in', navigate: true);
    }

    if (session()->has('id')) {
        $this->id = session()->get('id');
    }
})
?>

<div class="h-dvh flex flex-col">
    @if($path == 'sign-in')
    <livewire:sign-in />
    @elseif(in_array($path,['stock','manage-stock','setting','warehouse','manage-warehouse','inventory','manage-inventory','delivery','manage-delivery','user','manage-user','manage-quantity-types','sale','manage-sale']) )
    <livewire:nav-bar />
    <div class="flex justify-between grow">
        <div class="w-1/5 border-r-2 border-black/10">
            <livewire:side-bar />
        </div>
        <div class="w-4/5 h-full bg-black/10 px-4 py-8">
            @if($path == 'stock')
            <livewire:stock.stock />
            @elseif($path == 'manage-stock')
            <livewire:stock.manage-stock :id="$id" />
            @elseif($path == 'setting')
            <livewire:setting.setting />
            @elseif($path == 'warehouse')
            <livewire:warehouse.warehouse />
            @elseif($path == 'manage-warehouse')
            <livewire:warehouse.manage-warehouse :id="$id" />
            @elseif($path == 'inventory')
            <livewire:inventory.inventory />
            @elseif($path == 'manage-inventory')
            <livewire:inventory.manage-inventory :id="$id" />
            @elseif($path == 'manage-quantity-types')
            <livewire:inventory.manage-quantity-types />
            @elseif($path == 'delivery')
            <livewire:delivery.delivery :url="$url"/>
            @elseif($path == 'manage-delivery')
            <livewire:delivery.manage-delivery :id="$id" />
            @elseif($path == 'sale')
            <livewire:sale.sale />
            @elseif($path == 'manage-sale')
            <livewire:sale.manage-sale :id="$id" />
            @elseif($path == 'user')
            <livewire:user.user />
            @elseif($path == 'manage-user')
            <livewire:user.manage-user :id="$id" />
            @endif
        </div>
    </div>
    @elseif($path == 'delivery-preview')
    <livewire:delivery.delivery-preview :id="$id" />
    @endif
</div>