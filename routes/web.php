<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/admin', function () {
    return Inertia::render('Admin/AdminIndex');
})->name('admin.index');

Route::get('/dashboard', function () {
    return Inertia::render('components/Dashboard');
});

Route::prefix('admin')->group(function () {
    Route::inertia('/addcustomer', 'Admin/AddCustomer')->name('admin.addcustomer');
    Route::inertia('/viewcustomer', 'Admin/ViewCustomer')->name('admin.viewcustomer');

    Route::inertia('/adduser', 'Admin/AddUser')->name('admin.adduser');
    Route::inertia('/viewuser', 'Admin/ViewUser')->name('admin.viewuser');

    Route::inertia('/addproperties', 'Admin/AddProperties')->name('admin.addproperties');
    Route::inertia('/viewproperties', 'Admin/ViewProperties')->name('admin.viewproperties');
});
