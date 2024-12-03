<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Enums\UserType;
use Illuminate\Support\Facades\DB;

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
        // Customer Routes
        Route::inertia('/addcustomer', 'Admin/AddCustomer')->name('admin.addcustomer');
        Route::post('/addcustomer', [CustomerController::class, 'store']);
        Route::inertia('/viewcustomer', 'Admin/ViewCustomer', [
            'customers' => Schema::hasTable('customers') ? Customer::paginate(10) : [],
        ])->name('admin.viewcustomer');

        Route::get('/editcustomer/{id}', function ($id) {
            $customer = Customer::find($id);
            return Inertia::render('Admin/EditCustomer', ['customer' => $customer]);
        })->name('admin.editcustomer');

        Route::put('/updatecustomer/{id}', [CustomerController::class, 'update'])->name('admin.updatecustomer');
        // User Routes
        Route::inertia('/adduser', 'Admin/AddUser', [
            'userTypes' => UserType::toSelectArray(),
        ])->name('admin.adduser');
        Route::post('/adduser', [UserController::class, 'store']);
        Route::inertia('/viewuser', 'Admin/ViewUser', [
            'users' => Schema::hasTable('users') ? User::where('email', '!=', 'admin@example.com')->paginate(10) : [],
            'userTypes' => UserType::toSelectArray(),
        ])->name('admin.viewuser');
        Route::get('/edituser/{id}', function ($id) {
            $user = User::find($id);
            $userTypes = UserType::toSelectArray(); // Fetch the userTypes array
            return Inertia::render('Admin/EditUser', [
                'user' => $user,
                'userTypes' => $userTypes, // Pass the userTypes to the component
            ]);
        })->name('admin.edituser');

        Route::put('/updateuser/{id}', [UserController::class, 'update'])->name('admin.updateuser');

        // Property Routes
        Route::inertia('/addproperty', 'Admin/AddProperty', [
            'userTypes' => UserType::toSelectArray(),
            'countries' => Schema::hasTable('countries') ? Country::pluck('name', 'id') : [],
            'defaultData' => [
                    'states' => [],
                    'cities' => [],
                    'currency' => null,
                ],
            'customerOptions' => Schema::hasTable('customers') ? Customer::pluck('name', 'id') : [],
            'agentOptions' => Schema::hasTable('users') ? User::where('role','1')->pluck('name', 'id') : [],
            'propertySizeUnits' => Schema::hasTable('property_size_units') ? DB::table('property_size_units')->pluck('unit_key', 'id') : []     ,
        ])->name('admin.addproperty');
        Route::post('/addproperty', [PropertyController::class, 'store']);
        Route::inertia('/viewproperty', 'Admin/ViewProperty', [
            //'propertys' => property::paginate(10),
            'UserTypes' => UserType::toSelectArray(),
        ])->name('admin.viewproperty');

        // Route::get('/editproperty/{id}', function ($id) {
        //     $property = Property::find($id);
        //     return Inertia::render('Admin/EditProperty', ['property' => $property]);
        // })->name('admin.editproperty');
        Route::get('/editproperty/{id}', function ($id) {
            //$property = Property::find($id);
            $propertyTypes = UserType::toSelectArray(); // Fetch the propertyTypes array
            return Inertia::render('Admin/EditProperty', [
                //'property' => $property,
                //'userTypes' => $userTypes, // Pass the propertyTypes to the component
            ]);
        })->name('admin.editproperty');

        Route::put('/updateproperty/{id}', [PropertyController::class, 'update'])->name('admin.updateproperty');
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
        // In your admin route group
        Route::get('/viewproperty', [PropertyController::class, 'index'])->name('admin.viewproperty');
        Route::delete('/property/{id}', [PropertyController::class, 'destroy'])->name('admin.deleteproperty');
        Route::put('/property/{id}/toggle-status', [PropertyController::class, 'toggleStatus'])->name('admin.togglepropertystatus');

        Route::get('/editproperty/{id}', [PropertyController::class, 'edit'])->name('admin.editproperty');
        Route::put('/updateproperty/{id}', [PropertyController::class, 'update'])->name('admin.updateproperty');
    });

    // Dashboard and Logout
    Route::get('/admin', function () {
        return Inertia::render('Admin/AdminIndex');
    })->name('admin.index');

    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
