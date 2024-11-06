<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::get('/', function () {
    return redirect('/sign-in');
});
Volt::route('/sign-in', 'landing-page')->name('sign-in');
Volt::route('/stock', 'landing-page')->name('stock');
Volt::route('/manage-stock', 'landing-page')->name('manage-stock');
Volt::route('/inventory', 'landing-page')->name('inventory');
Volt::route('/manage-inventory', 'landing-page')->name('manage-inventory');
Volt::route('/setting', 'landing-page')->name('setting');
Volt::route('/warehouse', 'landing-page')->name('warehouse');
Volt::route('/manage-warehouse', 'landing-page')->name('manage-warehouse');