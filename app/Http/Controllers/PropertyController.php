<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\PropertySizeUnit;
use App\Models\State;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Storage;
use App\Models\Property;
use App\Models\User;

class PropertyController extends Controller
{
    public function store(Request $request)
    {
        if ($request->has('no')) {
            $request->merge(['no' => (string) $request->no]);
        }
        // First get the currency data from the countries table
        $countryCurrency = DB::table('countries')
            ->where('id', $request->country)
            ->select('currency')  // or 'currency_symbol' based on your needs
            ->first();

        $fields = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'no' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'integer'],
            'state' => ['required', 'integer'],
            'country' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'size' => ['required', 'numeric'],
            'unit' => ['required', 'integer'],
            'agent' => ['required', 'integer'],
            'customer' => ['required', 'integer'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['file', 'mimes:jpg,jpeg,png', 'max:3072'],
        ]);

        // Add the currency from the country
        $fields['currency'] = $countryCurrency->currency;  // or currency_symbol

        if ($request->hasFile('photos')) {
            $fields['photos'] = array_map(function ($photo) {
                // Generate a unique filename with timestamp and original extension
                $filename = time() . '_' . $photo->getClientOriginalName();

                // Store the file and return the path
                $path = $photo->storeAs('property_photos', $filename, 'public');

                return $path;
            }, $request->file('photos'));
        }

        $fields['agent_id'] = $fields['agent'];
        $fields['customer_id'] = $fields['customer'];
        unset($fields['agent'], $fields['customer']);

        $fields['flag'] = 0;
        $fields['status'] = 1;

        Property::create($fields);

        return redirect()->route('admin.viewproperty')->with('greet', 'Property successfully added!');
    }

    public function index()
    {
        $properties = Property::with([
            'agent:id,name',
            'customer:id,name',
            'countryData:id,name,currency_symbol',
            'stateData:id,name',
            'cityData:id,name',
            'unitData:id,unit_key'
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Add this for debugging
        //dd($properties);

        return Inertia::render('Admin/ViewProperty', [
            'properties' => $properties
        ]);
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);

        // Delete associated photos
        if ($property->photos) {
            foreach ($property->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $property->delete();

        return redirect()->back()->with('success', 'Property deleted successfully');
    }

    public function toggleStatus($id)
    {
        $property = Property::findOrFail($id);
        $property->flag = !$property->flag;
        $property->save();

        $message = $property->flag ? 'Property marked as sold' : 'Property marked as available';
        return redirect()->back()->with('success', $message);
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);

        return Inertia::render('Admin/EditProperty', [
            'property' => $property,
            'countries' => Country::pluck('name', 'id'),
            'defaultData' => [
                'states' => State::where('country_id', $property->country)->pluck('name', 'id'),
                'cities' => City::where('state_id', $property->state)->pluck('name', 'id'),
                'currency' => $property->countryData?->currency_symbol
            ],
            'customerOptions' => Customer::pluck('name', 'id'),
            'agentOptions' => User::where('role', '1')->pluck('name', 'id'),
            'propertySizeUnits' => PropertySizeUnit::pluck('unit_key', 'id')
        ]);
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $fields = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'no' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'integer'],
            'state' => ['required', 'integer'],
            'country' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'size' => ['required', 'numeric'],
            'unit' => ['required', 'integer'],
            'agent' => ['required', 'integer'],
            'customer' => ['required', 'integer'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['file', 'mimes:jpg,jpeg,png', 'max:3072'],
        ]);

        // Handle new photos
        if ($request->hasFile('photos')) {
            $newPhotos = array_map(function ($photo) {
                return Storage::disk('public')->put('property_photos', $photo);
            }, $request->file('photos'));

            $fields['photos'] = array_merge($property->photos ?? [], $newPhotos);
        } else {
            $fields['photos'] = $property->photos;
        }

        // Handle removed photos
        if ($request->removed_photos) {
            foreach ($request->removed_photos as $photo) {
                Storage::disk('public')->delete($photo);
                $fields['photos'] = array_diff($fields['photos'], [$photo]);
            }
        }

        $fields['agent_id'] = $fields['agent'];
        $fields['customer_id'] = $fields['customer'];
        unset($fields['agent'], $fields['customer']);

        $property->update($fields);

        return redirect()->route('admin.viewproperty')->with('success', 'Property updated successfully');
    }
}
