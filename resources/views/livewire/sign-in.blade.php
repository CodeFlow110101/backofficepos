<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state, rules};

state(['email', 'password']);

rules(['email' => 'required|email', 'password' => "required"]);
$submit = function (Request $request) {
    $this->validate();

    if (
        Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])
    ) {
        $request->session()->regenerate();
        $this->redirectRoute('stock', navigate: true);
    } else {
        $this->addError('email', 'Invalid Credentials');
    }
}

?>

<div class="h-dvh flex justify-center items-center">
    <div class="w-1/3 p-10 rounded-lg shadow-2xl shadow-black/40">
        <form wire:submit="submit" class="h-min grid grid-cols-1 gap-8 px-4">
            <div class="text-center text-amber-500 py-6 font-bold text-3xl">
                BackOffice POS
            </div>
            <div>
                <input wire:model="email" type="text" class="border w-full rounded-lg border-amber-500 outline-none p-3" placeholder="Email">
                @error('email')
                <div wire:transition.in.scale.origin.top.duration.1000ms class="text-red-500 text-sm">
                    <span class="error">{{ $message }}</span>
                </div>
                @enderror
            </div>
            <div>
                <input wire:model="password" type="password" class="border w-full rounded-lg border-amber-500 outline-none p-3" placeholder="Password">
                @error('password')
                <div wire:transition.in.scale.origin.top.duration.1000ms class="text-red-500 text-sm">
                    <span class="error">{{ $message }}</span>
                </div>
                @enderror
            </div>
            <button type="submit" class="bg-amber-500 rounded-lg whitespace-nowrap px-10 py-2 w-min mx-auto text-lg font-semibold text-white">
                <div wire:loading.remove>Sign in</div>
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