<?php

use App\Models\Inventory;

use function Livewire\Volt\{state, with};

with(fn() => ['inventories' => Inventory::with(['quantitytype'])->get()]);

$redirectToInventory = function ($id) {
    session()->flash('id', $id);
    $this->redirectRoute('manage-inventory', navigate: true);
};
?>


<div class="h-full flex flex-col gap-8">
    <div class="text-2xl flex justify-between items-center font-semibold text-black/70 capitalize">
        <div>
            {{request()->path()}}
        </div>
        <div class="flex justify-between gap-4 items-center">
            <a href="/manage-quantity-types" wire:navigate>
                <div class="bg-amber-500 inline-flex gap-3 rounded-lg whitespace-nowrap px-8 py-2 w-min mx-auto text-lg text-white">
                    <div class="inline-flex gap-0 items-center">
                        <div>
                            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.5 21h13M12 21V7m0 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm2-1.8c3.073.661 2.467 2.8 5 2.8M5 8c3.359 0 2.192-2.115 5.012-2.793M7 9.556V7.75m0 1.806-1.95 4.393a.773.773 0 0 0 .37.962.785.785 0 0 0 .362.089h2.436a.785.785 0 0 0 .643-.335.776.776 0 0 0 .09-.716L7 9.556Zm10 0V7.313m0 2.243-1.95 4.393a.773.773 0 0 0 .37.962.786.786 0 0 0 .362.089h2.436a.785.785 0 0 0 .643-.335.775.775 0 0 0 .09-.716L17 9.556Z" />
                            </svg>
                        </div>
                        <div>
                            <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        manage
                    </div>
                </div>
            </a>
            <a href="/manage-inventory" wire:navigate>
                <div class="bg-amber-500 inline-flex gap-3 rounded-lg whitespace-nowrap px-8 py-2 w-min mx-auto text-lg text-white">
                    <div class="inline-flex gap-0 items-center">
                        <div>
                            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                            </svg>
                        </div>
                        <div>
                            <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        create
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="grow flex flex-col gap-8 bg-white rounded-lg shadow-2xl shadow-black/30 p-4">
        <div class="flex justify-end relative">
            <div class="w-1/4 relative">
                <input class="w-full rounded-full border-2 border-black/30 outline-none py-2 pl-10 pr-4 text-black/70">
                <svg class="w-6 h-6 top-2.5 left-3 absolute text-black/30" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>
            </div>
        </div>
        <div class="overflow-y-auto max-h-[60vh] w-full">
            <table class="border-b border-black/20 overflow-hidden rounded-lg w-full">
                <thead class="bg-amber-500/30 text-black/50 w-full text-center">
                    <tr>
                        <th class="font-normal py-3">No</th>
                        <th class="font-normal py-3">Name</th>
                        <th class="font-normal py-3">Price</th>
                        <th class="font-normal py-3">Quantity Type</th>
                        <th class="font-normal py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventories as $inventory)
                    <tr class="text-black/50 border-b border-black/20 w-full text-center">
                        <td class="py-3">{{$loop->iteration}}</td>
                        <td class="py-3">{{$inventory->name}}</td>
                        <td class="py-3">{{$inventory->price}}</td>
                        <td class="py-3">{{$inventory->quantitytype->name}}</td>
                        <td wire:click="redirectToInventory({{$inventory->id}})" class="py-3 flex justify-center cursor-pointer">
                            <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                            </svg>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>