<?php

use function Livewire\Volt\{state};

//

?>

<div x-data="drag">
    <div class="relative overflow-hidden h-screen w-screen bg-gray-100">
        <!-- Pull-down notification bar -->
        <div
            x-bind:style="'transform: translateY(' + translateY + 'px)'"
            class="absolute top-0 left-0 w-full bg-blue-500 text-white h-20 flex items-center justify-center shadow-md transition-transform duration-200">
            <span>Pull Down for Notification</span>
        </div>

        <!-- Content area -->
        <div class="h-full w-full flex items-center justify-center">
            <p class="text-lg">Main Content Area</p>
        </div>
    </div>
</div>