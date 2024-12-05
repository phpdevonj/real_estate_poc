<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function store(Request $request){

        $fields = $request->validate([
            'name' => ['required', 'max:255'],
            'address' => ['nullable'],
            'mobile' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10'],
            'email' => ['required', 'email', 'max:255', 'unique:customers'],
        ]);
        Customer::create($fields);
        //Auth::login($user);
        return redirect()->route('admin.addcustomer')->with('greet', 'Succeffuly Saved');
    }

    public function edit($id){
        return redirect()->route('admin.editcustomer', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        // Retrieve the existing customer record
        $customer = Customer::findOrFail($id);
        // Validate input fields
        $fields = $request->validate([
            'name' => ['required', 'max:255'],
            'address' => ['nullable'],
            'mobile' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10'],
        ]);
        // Update the customer's record
        $customer->update($fields);
        // Redirect with a success message
        return redirect()->route('admin.viewcustomer', $customer->id)->with('greet', 'Successfully Updated');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('admin.viewcustomer')->with('greet', 'Successfully Deleted');
    }

}
