<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Models\Customers;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Home');
    })->name('home');
    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

});

Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::prefix('admin')->group(function () {
        Route::inertia('/addcustomer', 'Admin/AddCustomer')->name('admin.addcustomer');
        Route::post('/addcustomer', [CustomerController::class, 'store']);
        Route::inertia('/viewcustomer', 'Admin/ViewCustomer', [
            'customers' => Customers::paginate(10),
        ])->name('admin.viewcustomer');

        Route::get('/editcustomer/{id}', function ($id) {
            $customer = Customers::find($id);
            return Inertia::render('Admin/EditCustomer', ['customer' => $customer]);
        })->name('admin.editcustomer');

        Route::put('/updatecustomer/{id}', [CustomerController::class, 'update'])->name('admin.updatecustomer');

        Route::inertia('/adduser', 'Admin/AddUser')->name('admin.adduser');
        Route::inertia('/viewuser', 'Admin/ViewUser')->name('admin.viewuser');
        Route::inertia('/addproperties', 'Admin/AddProperties')->name('admin.addproperties');
        Route::inertia('/viewproperties', 'Admin/ViewProperties')->name('admin.viewproperties');
    });

    // Dashboard and Logout
    Route::get('/admin', function () {
        return Inertia::render('Admin/AdminIndex');
    })->name('admin.index');

    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
