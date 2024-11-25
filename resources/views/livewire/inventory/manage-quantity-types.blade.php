<?php

use App\Models\QuantityType;

use function Livewire\Volt\{state, rules, with, updated};

state(['name', 'id', 'search']);

rules(['name' => 'required']);

with(fn() => ['quantitytypes' => QuantityType::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%'])->get()]);

updated(['id' => fn() => $this->name = QuantityType::find($this->id)->name]);

$submit = function () {
    $this->validate();

    if ($this->id) {
        QuantityType::find($this->id)->update([
            'name' => $this->name,
        ]);
    } else {
        QuantityType::create([
            'name' => $this->name,
        ]);
    }

    $this->reset();
};
?>

<div x-data="{showDeleteModal:false}" class="h-full flex flex-col gap-8">
    <div class="text-2xl font-semibold text-black/70 capitalize">
        Manage quantity types
    </div>
    <div class="grow bg-white rounded-lg shadow-2xl shadow-black/30 p-4">
        <div class="h-full flex justify-between gap-4">
            <div class="flex flex-col gap-4 w-1/2">
                <div>
                    <div class="flex justify-end items-center gap-4 relative">
                        <div class="w-1/2 relative">
                            <input wire:model.live="search" class="w-full rounded-full border-2 border-black/30 outline-none py-2 pl-10 pr-4 text-black/70" placeholder="Search Stock">
                            <svg class="w-6 h-6 top-2.5 left-3 absolute text-black/30" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="w-full h-[55vh] overflow-y-auto">
                    <table class="border-b border-black/20 overflow-hidden rounded-lg w-full">
                        <thead class="bg-amber-500/30 text-black/50 w-full text-center">
                            <tr>
                                <th class="font-normal py-3">Sr no</th>
                                <th class="font-normal py-3">Name</th>
                                <th class="font-normal py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quantitytypes as $quantitytype)
                            <tr class="text-black/50 border-b border-black/20 w-full text-center">
                                <td class="font-normal text-center py-3">{{$loop->iteration}}</td>
                                <td class="font-normal text-center py-3">{{$quantitytype->name}}</td>
                                <td wire:click="$set('id', {{$quantitytype->id}})" class="py-3 flex justify-center cursor-pointer">
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
            <div class="w-1/2">
                <div class="flex justify-center size-full items-center border border-black/30 rounded-xl">
                    <div class="size-full flex flex-col w-11/12">
                        <form wire:submit="submit" class="h-min grid grid-cols-1 gap-8 py-8 px-4">
                            <div>
                                <input wire:model="name" class="border w-full rounded-lg text-black/70 border-black/30 outline-none p-3" placeholder="Name">
                                @error('name')
                                <div wire:transition.in.scale.origin.top.duration.1000ms class="text-red-500 text-sm">
                                    <span class="error">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                            <div class="flex justify-around">
                                <button type="submit" class="bg-amber-500 rounded-lg whitespace-nowrap px-10 py-2 w-min text-lg text-white">
                                    <div wire:loading.remove wire:target="submit">{{ $id ? 'Update' : 'Submit'}}</div>
                                    <div>
                                        <svg wire:loading wire:target="submit" aria-hidden="true" class="w-8 h-8 text-transparent animate-spin fill-white" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>