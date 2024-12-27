<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleBasedAccess;
use App\Models\Country;
use App\Models\Customer;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Enums\UserType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        $categories = PropertyType::select('id', 'name', 'category')->get();

        // Debug output to Laravel log
        \Log::info('Categories data:', [
            'count' => $categories->count(),
            'data' => $categories->toArray()
        ]);

        return Inertia::render('Home', [
            'property_categories' => $categories
        ]);
        })->name('home');
    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Common Routes
    Route::get('/admin', function () {
        return Inertia::render('Admin/AdminIndex');
    })->name('admin.index');
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Shared Routes (Admin & Agent)
    Route::prefix('admin')->middleware([
        RoleBasedAccess::class . ':' . UserType::Admin . ',' . UserType::Agent])->group(function () {
        // Property Routes
        Route::controller(PropertyController::class)->group(function () {
            Route::get('/addproperty', 'create')->name('admin.addproperty');
            Route::post('/addproperty', 'store');
            Route::get('/viewproperty', 'index')->name('admin.viewproperty');
            Route::get('/editproperty/{id}', 'edit')->name('admin.editproperty');
            Route::put('/updateproperty/{id}', 'update')->name('admin.updateproperty');
            Route::delete('/property/{id}', 'destroy')->name('admin.deleteproperty');
            Route::put('/property/{id}/toggle-status', 'toggleStatus')->name('admin.togglepropertystatus');
        });

        // Location Data Routes
        Route::get('/getcountrydata/{countryId}', function ($countryId) {
            return response()->json([
                'states' => DB::table('states')->where('country_id', $countryId)->pluck('name', 'id'),
                'cities' => DB::table('cities')->where('country_id', $countryId)->pluck('name', 'id'),
                'currency' => DB::table('countries')
                    ->where('id', $countryId)
                    ->select('currency', 'currency_name', 'currency_symbol')
                    ->first(),
            ]);
        })->name('getcountrydata');

        Route::get('/getstatecities/{stateId}', function ($stateId) {
            return response()->json([
                'cities' => DB::table('cities')
                    ->where('state_id', $stateId)
                    ->pluck('name', 'id'),
            ]);
        })->name('getstatecities');
    });

    // Admin Only Routes
    Route::prefix('admin')->middleware([
        RoleBasedAccess::class . ':' . UserType::Admin])->group(function () {
        // Customer Routes
        Route::controller(CustomerController::class)->group(function () {
            Route::inertia('/addcustomer', 'Admin/AddCustomer')->name('admin.addcustomer');
            Route::post('/addcustomer', 'store');
            Route::inertia('/viewcustomer', 'Admin/ViewCustomer', [
                'customers' => Schema::hasTable('customers') ? Customer::paginate(10) : [],
            ])->name('admin.viewcustomer');
            Route::delete('/deletecustomer/{id}', 'destroy')->name('admin.deletecustomer');
            Route::put('/updatecustomer/{id}', 'update')->name('admin.updatecustomer');
        });

        Route::get('/editcustomer/{id}', function ($id) {
            return Inertia::render('Admin/EditCustomer', ['customer' => Customer::find($id)]);
        })->name('admin.editcustomer');

        // User Routes
        Route::controller(UserController::class)->group(function () {
            Route::inertia('/adduser', 'Admin/AddUser', [
                'userTypes' => UserType::toSelectArray(),
            ])->name('admin.adduser');
            Route::post('/adduser', 'store');
            Route::inertia('/viewuser', 'Admin/ViewUser', [
                'users' => Schema::hasTable('users') ? User::where('email', '!=', 'admin@example.com')->paginate(10) : [],
                'userTypes' => UserType::toSelectArray(),
            ])->name('admin.viewuser');
            Route::delete('/deleteuser/{id}', 'destroy')->name('admin.deleteuser');
            Route::put('/updateuser/{id}', 'update')->name('admin.updateuser');
        });

        Route::get('/edituser/{id}', function ($id) {
            return Inertia::render('Admin/EditUser', [
                'user' => User::find($id),
                'userTypes' => UserType::toSelectArray(),
            ]);
        })->name('admin.edituser');
    });
});

// Test Route
Route::get('/test', function () {
    return 'test';
})->middleware([RoleBasedAccess::class . ':0'])->name('test');

Route::get('/property', [PropertyController::class, 'getProperty']);
Route::get('/agents', [UserController::class, 'getAgents']);

