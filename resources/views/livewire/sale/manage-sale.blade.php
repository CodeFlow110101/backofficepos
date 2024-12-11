<?php

use App\Models\Delivery;
use App\Models\DeliveyStock;
use App\Models\Sale;
use App\Models\SalesStock;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{state, mount, rules, with, updated, computed, on};

state(['search', 'filter' => 0, 'selectedStocks' => [], 'stall', 'deliveryId', 'saleId', 'fileSize', 'fileName', 'filePath']);

rules(['selectedStocks' => 'required', 'stall' => 'required', 'fileSize' => 'required|lt:5'])->messages([
    'fileSize.required' => 'The file is required.',
    'fileSize.lt' => 'The file size should be less than 5MB.',
])->attributes([
    'stall' => 'Stall Name',
]);

with(fn() => [
    'deliverystocks' => DeliveyStock::when(
        $this->filter != 0,
        function ($query) {
            if ($this->filter == 1) {
                $query->whereIn('id', array_keys($this->selectedStocks));
            } else {
                $query->whereNotIn('id', array_keys($this->selectedStocks));
            }
        }
    )->with(['stock.inventory'])
        ->whereHas('stock.inventory', function ($query) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']);
        })->where('delivery_id', $this->deliveryId)->get(),
    'filters' => [0 => 'all', 1 => 'selected', 2 => 'Not Selected'],
    'deliveries' => Delivery::get(),
]);

updated(['deliveryId' => fn() => $this->selectedStocks = []]);

$totalPrice = computed(function () {
    $total = 0;

    foreach (
        DeliveyStock::with(['stock.inventory'])->whereHas('stock', function ($query) {
            $query->whereIn('id', array_keys($this->selectedStocks));
        })->get() as $deliverystock
    ) {
        $total += $this->selectedStocks[$deliverystock->stock->id] * $deliverystock->stock->inventory->price;
    }

    return $total;
});

on(['handle-file' => function ($name, $path) {
    $this->fileName = $name;
    $this->filePath = $path;
    $this->createStock();
    $this->dispatch('loader', value: false);
    $this->redirectRoute('sale', navigate: true);
}]);

$updateQuantity = function ($id, $quantity) {
    if ($quantity > 0) {
        $this->selectedStocks[$id] = $quantity;
    } else {
        if (array_key_exists($id, $this->selectedStocks)) {
            unset($this->selectedStocks[$id]);
        }
    }
};

$delete = function () {
    $sale = Sale::with(['delivery.stocks'])->find($this->saleId);

    foreach ($sale->salestocks as $stock) {
        $sale->delivery->stocks->where('stock_id', $stock->stock_id)->each(function ($deliveryStock) use ($stock) {
            $deliveryStock->increment('quantity', $stock->quantity);
        });
        $stock->delete();
    }
    Storage::disk('public')->delete($this->filePath);
    $sale->delete();
    $this->redirectRoute('sale', navigate: true);
};

$submit = function () {
    $this->validate();

    if (!$this->isStockAvailable()) {
        $this->addError('selectedStocks', 'Some of the stocks are not available');
        return;
    }

    $this->dispatch('upload-file');
};

$createStock = function () {
    $sale = Sale::create([
        'delivery_id' => $this->deliveryId,
        'stall' => $this->stall,
        'file_name' => $this->fileName,
        'file_path' => $this->filePath
    ]);

    foreach ($this->selectedStocks as $id => $quantity) {
        SalesStock::create([
            'sale_id' => $sale->id,
            'stock_id' => $id,
            'quantity' => $quantity,
        ]);

        DeliveyStock::where('stock_id', $id)->where('delivery_id', $this->deliveryId)->first()->decrement('quantity', $quantity);
    }
};

$download = function () {
    return response()->download(public_path('storage/' . $this->filePath), $this->fileName);
};

$isStockAvailable = function () {
    $delivery = Delivery::with('stocks')->find($this->deliveryId);

    $validationStatus = false;

    foreach ($this->selectedStocks as $id => $stock) {

        $validationStatus = $stock > $delivery->stocks->where('stock_id', $id)->first()->quantity;

        if ($validationStatus) {
            return !$validationStatus;
        }
    }

    return !$validationStatus;
};

mount(function ($id) {
    if ($id) {
        $this->saleId = $id;
        $sale = Sale::with(['delivery', 'salestocks'])->find($id);
        $this->deliveryId = $sale->delivery->id;
        $this->stall = $sale->stall;
        $this->filePath = $sale->file_path;
        $this->fileName = $sale->file_name;
        foreach ($sale->salestocks as $stock) {
            $this->selectedStocks[$stock->stock_id] = $stock->quantity;
        }
    }
});

?>

<div x-data="{showDeleteModal:false}" class="h-full flex flex-col gap-8">
    <div class="text-2xl font-semibold text-black/70 capitalize">
        {{($deliveryId ? 'edit' : 'add').' sale'}}
    </div>
    <div class="grow bg-white rounded-lg shadow-2xl shadow-black/30 p-4">
        <div class="h-full flex justify-between gap-4">
            <div class="flex flex-col gap-4 w-1/2">
                <div>
                    <div class="flex justify-between items-center gap-4 relative">
                        <div class="w-full group relative rounded-full">
                            <div class="rounded-full bg-amber-500 p-2 flex justify-start gap-4">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                                </svg>
                                <div class="text-white capitalize" x-model="$wire.filter">{{$filters[$filter]}}</div>
                            </div>
                            <div class="absolute scale-y-0 group-hover:scale-y-100 bg-white w-full shadow-lg border border-black/30 rounded-lg overflow-hidden">
                                @foreach($filters as $id => $name)
                                <div wire:click="$set('filter', {{$id}})" class="pl-8 py-2 capitalize transition-colors duration-200 @if($id == $filter) bg-amber-500 text-white @else bg-white hover:bg-amber-500 text-black/60 hover:text-white @endif">{{$name}}</div>
                                @endforeach
                            </div>
                        </div>
                        <div class="w-full relative">
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
                                <th class="font-normal py-3">Name</th>
                                <th class="font-normal py-3">Avl Qty</th>
                                <th class="font-normal py-3">Qty</th>
                                <th class="font-normal py-3">Price</th>
                                <th class="font-normal py-3">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deliverystocks as $deliverystock)
                            <tr wire:key="{{ $deliverystock->id }}" x-data="deliveryStockQuantityValidator" x-init="$watch('quantity', value => validate()); avlStock={{ $deliverystock->quantity }}; stockPrice={{ $deliverystock->stock->inventory->price }}; quantity={{array_key_exists($deliverystock->stock->id,$selectedStocks) ? $selectedStocks[$deliverystock->stock->id] : 0}}; totalStock={{ (array_key_exists($deliverystock->stock->id,$selectedStocks) && $deliveryId) ?  ($selectedStocks[$deliverystock->stock->id] + $deliverystock->quantity) : 0}};" class="text-black/50 border-b border-black/20 w-full text-center">
                                <td class="font-normal text-center py-3">{{$deliverystock->stock->inventory->name}}</td>
                                <td class="font-normal text-center py-3">{{$deliverystock->quantity}}</td>
                                <td class="font-normal text-center py-3">
                                    @if($saleId)
                                    <input @if($deliveryId) disabled @endif value="{{array_key_exists($deliverystock->stock->id,$selectedStocks) ? $selectedStocks[$deliverystock->stock->id] : 0}}" class="w-14 text-center border border-black/30 rounded-md outline-none">
                                    @else
                                    <input x-model="quantity" wire:change="updateQuantity({{ $deliverystock->stock->id }}, quantity)" x-mask:dynamic="mask" class="w-14 text-center border border-black/30 rounded-md outline-none">
                                    @endif
                                </td>
                                <td class="font-normal text-center py-3">{{$deliverystock->stock->inventory->price . '/' . $deliverystock->stock->inventory->quantitytype->name}}</td>
                                <td class="font-normal text-center py-3" x-text="quantity*stockPrice"></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between items-center p-2 mt-auto">
                    <div>
                        @error('selectedStocks')
                        <div wire:transition.in.scale.origin.top.duration.1000ms class="text-red-500 text-sm">
                            <span class="error">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <div class="text-lg text-black/60 font-semibold">Total Price:Rp {{$this->totalPrice}}</div>
                </div>
            </div>
            <div class="w-1/2">
                <div class="flex justify-center size-full items-center border border-black/30 rounded-xl">
                    <div class="size-full flex flex-col w-11/12">
                        <form wire:submit="submit" class="h-min grid grid-cols-1 gap-8 py-8 px-4">
                            <div>
                                <select @if($saleId) disabled @endif wire:model.live="deliveryId" class="border w-full rounded-lg text-black/70 border-black/30 outline-none p-3">
                                    <option selected value="0">Select a Delivery</option>
                                    @foreach($deliveries as $delivery)
                                    <option value="{{$delivery->id}}">{{$delivery->id}}</option>
                                    @endforeach
                                </select>
                                @error('deliveryId')
                                <div wire:transition.in.scale.origin.top.duration.1000ms class="text-red-500 text-sm">
                                    <span class="error">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                            <div>
                                <input @if($saleId) disabled @endif wire:model="stall" class="border w-full rounded-lg text-black/70 border-black/30 outline-none p-3" placeholder="Stall Name">
                                @error('stall')
                                <div wire:transition.in.scale.origin.top.duration.1000ms class="text-red-500 text-sm">
                                    <span class="error">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                            @if($saleId)
                            <div class="border border-black/30 w-full rounded-lg p-3 flex justify-between items-center">
                                <div class="flex justify-start items-center gap-2">
                                    <div>
                                        <svg class="w-6 h-6 text-amber-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m14-4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                                        </svg>
                                    </div>
                                    <div>{{$this->fileName}}</div>
                                </div>
                                <button wire:click="download" class="rounded-full p-1 hover:bg-amber-500 transition-colors duration-200 group">
                                    <svg class="w-6 h-6 text-amber-500 group-hover:text-white duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01" />
                                    </svg>
                                </button>
                            </div>
                            @else
                            <div x-data="handleFile" x-on:upload-file.window="uploadFile">
                                <input @if($saleId) disabled @endif @change="handleFileSelect" x-ref="file" type="file" class="border w-full rounded-lg text-black/70 border-black/30 outline-none p-3 file:rounded-md file:bg-amber-500/30 file:text-black/50 file:border file:border-transparent file:p-2 hover:file:cursor-pointer hover:file:bg-amber-500 hover:file:text-white file:transition-colors file:duration-200 file:mr-4 file:font-semibold file:outline-none">
                                <input wire:model="fileSize" class="hidden">
                                @error('fileName')
                                <div wire:transition.in.scale.origin.top.duration.1000ms class="text-red-500 text-sm">
                                    <span class="error">{{ $message }}</span>
                                </div>
                                @enderror
                                @error('fileSize')
                                <div wire:transition.in.scale.origin.top.duration.1000ms class="text-red-500 text-sm">
                                    <span class="error">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                            @endif
                            <div class="flex justify-around">
                                @if(!$saleId)
                                <button x-data="{ loader : false }" x-on:loader.window="loader = $event.detail.value" type="submit" :class="loader && 'pointer-events-none'" class="bg-amber-500 rounded-lg whitespace-nowrap px-10 py-2 w-min text-lg text-white">
                                    <div wire:loading.remove wire:target="submit" x-show="!loader">Submit</div>
                                    <div wire:loading.class.remove="hidden" wire:target="submit" :class="loader ? '' : 'hidden'">
                                        <svg aria-hidden="true" class="w-8 h-8 text-transparent animate-spin fill-white" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                        </svg>
                                    </div>
                                </button>
                                @else
                                <button @click="showDeleteModal = true" type="button" class="bg-amber-500 rounded-lg whitespace-nowrap px-10 py-2 w-min text-lg text-white">
                                    <div wire:loading.remove wire:target="submit">Delete</div>
                                </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($deliveryId)
    <div x-cloak x-show="showDeleteModal" class="fixed inset-0 flex justify-center items-center">
        <div x-show="showDeleteModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="size-2/5 bg-white rounded-xl shadow-lg border border-black/30 p-4 flex flex-col">
            <div class="flex justify-end">
                <button @click="showDeleteModal = false" class="rounded-full group hover:bg-black/20 transition-colors duration-200 p-1">
                    <svg class="w-6 h-6 text-black/60 group-hover:text-white transition-colors duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                </button>
            </div>
            <div class="grow flex flex-col justify-around">
                <div class="text-black/60 text-xl font-semibold text-center">Do you really want to delete this sales note?</div>
                <div class="flex justify-around w-1/2 mx-auto">
                    <button @click="showDeleteModal = false" class="border border-black/30 py-2 px-4 rounded-xl font-semibold text-black/60">No</button>
                    <button wire:click="delete" class="py-2 px-4 rounded-xl font-semibold text-black/60 bg-amber-500 text-white">Yes</button>
                </div>
            </div>
            <div class="border-t py-2 border-black/30 text-sm font-semibold text-black/60 italic">Note: This action will revert back all the stocks from the sales note to there respective delivery note.</div>
        </div>
    </div>
    @endif
</div>