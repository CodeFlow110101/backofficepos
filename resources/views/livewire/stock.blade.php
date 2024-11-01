<?php

use function Livewire\Volt\{state};

//

?>

<div class="h-full flex flex-col gap-8">
    <div class="text-2xl font-semibold text-black/70 capitalize">{{request()->path()}}</div>
    <div class="grow bg-white rounded-lg shadow-2xl shadow-black/30"></div>
</div>