<?php

use function Livewire\Volt\{state};

//

?>

<div class="h-full flex flex-col gap-8">
    <div class="text-2xl font-semibold text-black/70 capitalize">{{request()->path()}}</div>
    <div class="grow flex flex-col gap-8 bg-white rounded-lg shadow-2xl shadow-black/30 p-4">
        <div class="grow flex justify-between gap-4">
            <div class="grid grid-cols-1 gap-2 h-min w-1/2">
                <div class="text-black/30 font-semibold text-lg">Update Details</div>
                <div>
                    <div class="border border-black/30 w-4/5"></div>
                </div>
            </div>
            <div class="w-1/2">
                <livewire:setting.update-detail />
            </div>
        </div>
        <div class="grow flex justify-between gap-4">
            <div class="grid grid-cols-1 gap-2 h-min w-1/2">
                <div class="text-black/30 font-semibold text-lg">Update Password</div>
                <div>
                    <div class="border border-black/30 w-4/5"></div>
                </div>
            </div>
            <div class="w-1/2">
                <livewire:setting.update-password />
            </div>
        </div>
    </div>
</div>