<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::get('/', function () {
    return redirect('/sign-in');
});
Volt::route('/sign-in', 'landing-page')->name('sign-in');
Volt::route('/stock', 'landing-page')->name('stock');
