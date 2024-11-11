<?php

use App\Models\Inventory;
use App\Models\Stock;
use App\Models\Warehouse;

use function Livewire\Volt\{state, mount, rules, with};

state(['warehouse', 'inventory', 'price', 'quantity', 'id']);

rules(['warehouse' => 'required', 'inventory' => 'required', 'price' => 'required|numeric', 'quantity' => 'required|numeric']);

with(fn() => [
    'warehouses' => Warehouse::get(),
    'inventories' => Inventory::get()
]);

mount(function ($id) {
    $this->id = $id;
    if ($id) {
        $stock = Stock::find($id);
        $this->warehouse = $stock->warehouse_id;
        $this->inventory = $stock->inventory_id;
        $this->price = $stock->price;
        $this->quantity = $stock->quantity;
    }
});

?>

<div class="h-full flex flex-col gap-8">
    <div class="text-2xl font-semibold text-black/70 capitalize">
        {{($id ? 'edit' : 'add').' stock'}}
    </div>
    <div class="grow bg-white rounded-lg shadow-2xl shadow-black/30 p-4">
        <div class="h-full flex justify-between gap-4">
            <div class="grid grid-cols-1 gap-2 h-min w-1/2">
                <div class="text-black/30 font-semibold text-lg">Details</div>
                <div>
                    <div class="border border-black/30 w-4/5"></div>
                </div>
            </div>
            <div class="w-1/2">
                <div class="flex justify-center size-full items-center border border-black/30 rounded-xl">
                    <form wire:submit="submit" class="h-full flex flex-col gap-8 py-8 px-4 w-11/12">
                        <div>
                            <select @if($this->id) disabled @endif wire:model="warehouse" class="border w-full rounded-lg text-black/70 border-black/30 outline-none p-3">
                                <option selected value="">Select a Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                <option selected value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                            @error('warehouse')
                            <div wire:transition.in.scale.origin.top.duration.1000ms class="text-red-500 text-sm">
                                <span class="error">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                        <div>
                            <select @if($this->id) disabled @endif wire:model="inventory" class="border w-full rounded-lg text-black/70 border-black/30 outline-none p-3">
                                <option selected value="">Select an Inventory</option>
                                @foreach($inventories as $inventory)
                                <option selected value="{{$inventory->id}}">{{$inventory->name}}</option>
                                @endforeach
                            </select>
                            @error('inventory')
                            <div wire:transition.in.scale.origin.top.duration.1000ms class="text-red-500 text-sm">
                                <span class="error">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                        <div>
                            <div class="inline-flex items-center gap-3 w-full">
                                <div>
                                    <svg class="w-5 h-5" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 105.17">
                                        <title>indonesian-rupiah</title>
                                        <path d="M67.5,105.17V21.89H85.1l3.22,5.26a51.88,51.88,0,0,1,4.19-3.22A17.93,17.93,0,0,1,97,21.73a17.36,17.36,0,0,1,5.53-.8,21,21,0,0,1,9,1.82,15.8,15.8,0,0,1,6.39,5.53,26.77,26.77,0,0,1,3.76,9.39A63.57,63.57,0,0,1,122.88,51a65.14,65.14,0,0,1-1.66,15.67A18.86,18.86,0,0,1,115.15,77q-4.4,3.64-12.66,3.65A43.84,43.84,0,0,1,95.08,80a26.88,26.88,0,0,1-6.76-2v27.26ZM95.41,63.53a6,6,0,0,0,3-.91A6.76,6.76,0,0,0,101,59a24,24,0,0,0,1-8.05,35.62,35.62,0,0,0-.75-8.32,7,7,0,0,0-2.2-4,5.87,5.87,0,0,0-3.6-1.08,12.1,12.1,0,0,0-4.18.7,13,13,0,0,0-3,1.45V61.92a8.49,8.49,0,0,0,3.06,1.18,18.83,18.83,0,0,0,4,.43ZM20.82,35.74h9.44a8.37,8.37,0,0,0,3-.49,5.3,5.3,0,0,0,2.2-1.55A6.83,6.83,0,0,0,36.81,31a16.12,16.12,0,0,0,.43-4,15.43,15.43,0,0,0-.43-4,5.5,5.5,0,0,0-1.34-2.53,5.68,5.68,0,0,0-2.2-1.34,9.71,9.71,0,0,0-3-.43H20.82V35.74ZM0,79.74V0H34a34.25,34.25,0,0,1,9.66,1.29A18.43,18.43,0,0,1,51.3,5.63a20.18,20.18,0,0,1,5,8.21,40.57,40.57,0,0,1,1.77,13,38.06,38.06,0,0,1-.86,8.59,22.85,22.85,0,0,1-2.31,6.17,16.27,16.27,0,0,1-3.43,4.24,27.1,27.1,0,0,1-4.24,3L61.06,79.74H39.92L28.76,52.26H20.82V79.74Z" />
                                    </svg>
                                </div>
                                <input x-mask="99999" wire:model="price" type="text" class="border w-full rounded-lg text-black/70 border-black/30 outline-none p-3" placeholder="Price">
                                <div>/kg</div>
                            </div>
                            @error('price')
                            <div wire:transition.in.scale.origin.top.duration.1000ms class="text-red-500 text-sm">
                                <span class="error">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                        <div>
                            <input x-mask="99999" wire:model="quantity" type="text" class="border w-full rounded-lg text-black/70 border-black/30 outline-none p-3" placeholder="Quantity">
                            @error('quantity')
                            <div wire:transition.in.scale.origin.top.duration.1000ms class="text-red-500 text-sm">
                                <span class="error">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="bg-amber-500 rounded-lg whitespace-nowrap px-10 py-2 w-min mx-auto text-lg text-white">
                            <div wire:loading.remove>Submit</div>
                            <div>
                                <svg wire:loading aria-hidden="true" class="w-8 h-8 text-transparent animate-spin fill-white" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                </svg>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>