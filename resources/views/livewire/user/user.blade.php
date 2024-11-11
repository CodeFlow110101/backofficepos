<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{mount, with};

with(fn() => ['users' => User::where('id', '!=', Auth::user()->id)->with(['role'])->get()]);

$redirectToUser = function ($id) {
    session()->flash('id', $id);
    $this->redirectRoute('manage-user', navigate: true);
};
?>


<div class="h-full flex flex-col gap-8">
    <div class="text-2xl flex justify-between items-center font-semibold text-black/70 capitalize">
        <div>
            {{request()->path()}}
        </div>
        <a href="/manage-user" wire:navigate>
            <div class="bg-amber-500 inline-flex gap-3 rounded-lg whitespace-nowrap px-8 py-2 w-min mx-auto text-lg text-white">
                <div class="inline-flex gap-0 items-center">
                    <div>
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
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
                        <th class="font-normal py-3">Role</th>
                        <th class="font-normal py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="text-black/50 border-b border-black/20 w-full text-center">
                        <td class="py-3">{{$loop->iteration}}</td>
                        <td class="py-3">{{$user->name}}</td>
                        <td class="py-3 capitalize">{{$user->role->name}}</td>
                        <td wire:click="redirectToUser({{$user->id}})" class="py-3 flex justify-center cursor-pointer">
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