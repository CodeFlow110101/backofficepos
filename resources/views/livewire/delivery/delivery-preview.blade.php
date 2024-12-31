<?php

use App\Models\Delivery;
use Carbon\Carbon;

use function Livewire\Volt\{state, mount, with};

state(['id']);

with(fn() => ['delivery' => Delivery::with(['warehouse', 'user', 'issued_by_user', 'stocks.stock.inventory'])->find($this->id)]);

mount(function ($id) {
    $this->id = $id;
});
?>

<div class="grow flex justify-center">
    <div class="w-11/12 my-10 flex flex-col gap-12">
        <div class="flex justify-start items-center gap-4">
            <div>
                <svg class="w-12 h-12 text-amber-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11.782 5.72a4.773 4.773 0 0 0-4.8 4.173 3.43 3.43 0 0 1 2.741-1.687c1.689 0 2.974 1.972 3.758 2.587a5.733 5.733 0 0 0 5.382.935c2-.638 2.934-2.865 3.137-3.921-.969 1.379-2.44 2.207-4.259 1.231-1.253-.673-2.19-3.438-5.959-3.318ZM6.8 11.979A4.772 4.772 0 0 0 2 16.151a3.431 3.431 0 0 1 2.745-1.687c1.689 0 2.974 1.972 3.758 2.587a5.733 5.733 0 0 0 5.382.935c2-.638 2.933-2.865 3.137-3.921-.97 1.379-2.44 2.208-4.259 1.231-1.253-.673-2.19-3.443-5.963-3.317Z" />
                </svg>
            </div>
            <div class="text-amber-500 font-bold text-xl">
                BackOffice POS
            </div>
        </div>
        <div class="text-center text-xl font-semibold">Fruit Delivery</div>
        <div class="flex justify-between">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2 text-lg">
                    <div class="font-semibold">{{ $delivery->warehouse->name }}</div>
                    <div>{{ $delivery->warehouse->address }}</div>
                </div>
                <div>
                    Vehicle NO : {{ $delivery->vehicle_no }}
                </div>
                <div>
                    Salesperson : {{ $delivery->user->name }}
                </div>
            </div>
            <div class="flex flex-col gap-4">
                <div>Delivery No : {{ $delivery->id }}</div>
                <div>Date : {{ Carbon::parse($delivery->created_at)->format('j F Y') }}</div>
            </div>
        </div>
        <div>
            <table class="w-full">
                <thead class="bg-black/10 border-y border-black">
                    <tr>
                        <th class="py-2">No</th>
                        <th class="py-2">Id</th>
                        <th class="py-2">Item</th>
                        <th class="py-2">Price</th>
                        <th class="py-2">Quantity</th>
                        <th class="py-2">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($delivery->stocks as $stock)
                    <tr class="text-center border-b border-black">
                        <td class="py-3">{{ $loop->iteration }}</td>
                        <td class="py-3">{{ $stock->stock->inventory->id }}</td>
                        <td class="py-3">{{ $stock->stock->inventory->name }}</td>
                        <td class="py-3">Rp {{ $stock->stock->inventory->price }}</td>
                        <td class="py-3">{{ $stock->original_quantity }}</td>
                        <td class="py-3">Rp {{ $stock->stock->inventory->price*$stock->original_quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="h-[20vh]"></div>
        <div class="grid grid-cols-1 divide-y divide-black border border-black">
            <div class="grid grid-cols-4 text-center divide-x divide-black">
                <div class="py-2">Issued by</div>
                <div class="py-2">Approved by</div>
                <div class="py-2">Delivered by</div>
                <div class="py-2">Recieved by</div>
            </div>
            <div class="grid grid-cols-4 divide-x divide-black">
                <div class="h-[20vh]"></div>
                <div class="h-[20vh]"></div>
                <div class="h-[20vh]"></div>
                <div class="h-[20vh]"></div>
            </div>
            <div class="grid grid-cols-4 divide-x divide-black">
                <div>
                    <div class="p-2">Name: {{ $delivery->issued_by_user->name }}</div>
                </div>
                <div>
                    <div class="p-2">Name:</div>
                </div>
                <div>
                    <div class="p-2">Name: {{ $delivery->user->name }}</div>
                </div>
                <div>
                    <div class="p-2">Name:</div>
                </div>
            </div>
            <div class="grid grid-cols-4 divide-x divide-black">
                <div>
                    <div class="p-2">Date: {{ Carbon::parse($delivery->created_at)->format('j F Y') }}</div>
                </div>
                <div>
                    <div class="p-2">Date:</div>
                </div>
                <div>
                    <div class="p-2">Date: {{ Carbon::parse($delivery->created_at)->format('j F Y') }}</div>
                </div>
                <div>
                    <div class="p-2">Date:</div>
                </div>
            </div>
        </div>
    </div>
</div>