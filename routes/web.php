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
Volt::route('/delivery', 'landing-page')->name('delivery');
Volt::route('/manage-delivery', 'landing-page')->name('manage-delivery');
Volt::route('/user', 'landing-page')->name('user');
Volt::route('/manage-user', 'landing-page')->name('manage-user');
Volt::route('/manage-quantity-types', 'landing-page')->name('manage-quantity-types');
Volt::route('/test', 'sale.sale')->name('test');