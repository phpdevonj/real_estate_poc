<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\PropertySizeUnit;
use App\Models\PropertyType;
use App\Models\State;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Schema;
use Storage;
use App\Models\Property;
use App\Models\User;
use App\Enums\UserType;
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
        // If user is an agent, force the agent field to be their own ID
        if (auth()->user()->type === UserType::Agent) {
            $fields['agent'] = auth()->id();
        }
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
        } else {
            // Set empty array when no photos are uploaded
            $fields['photos'] = [];
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
        $user = auth()->user();

        // \Log::info('User Role Check:', [
        //     'user_id' => $user->id,
        //     'role' => $user->role,
        //     'is_admin' => $user->role === 0
        // ]);

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

        return Inertia::render('Admin/ViewProperty', [
            'properties' => $properties,
            'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => (int)$user->role  // Ensure role is cast to integer
                ],
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
            'removed_photos' => ['nullable', 'array']
        ]);
        // Initialize photos array
        $updatedPhotos = is_array($property->photos) ? $property->photos : [];
        // Handle removed photos
        if ($request->removed_photos) {
            foreach ($request->removed_photos as $photo) {
                $filename = 'property_photos/' . basename($photo);
                // Delete from storage
                if (Storage::disk('public')->exists($filename)) {
                    Storage::disk('public')->delete($filename);
                }
                // Remove from photos array
                $updatedPhotos = array_values(array_filter($updatedPhotos, function($existingPhoto) use ($filename) {
                    return $existingPhoto !== $filename;
                }));
            }
        }
        // Handle new photos
        if ($request->hasFile('photos')) {
            $newPhotos = array_map(function ($photo) {
                $filename = time() . '_' . $photo->getClientOriginalName();
                return $photo->storeAs('property_photos', $filename, 'public');
            }, $request->file('photos'));

            $updatedPhotos = array_merge($updatedPhotos, $newPhotos);
        }
        // Ensure we don't exceed 4 photos
        $updatedPhotos = array_slice($updatedPhotos, 0, 4);

        $fields['photos'] = $updatedPhotos;
        $fields['agent_id'] = $fields['agent'];
        $fields['customer_id'] = $fields['customer'];
        unset($fields['agent'], $fields['customer']);

        $property->update($fields);

        return redirect()->route('admin.viewproperty')->with('success', 'Property updated successfully');
    }

    public function create()
    {
        $user = auth()->user();

        //\Log::info('=== ADD PROPERTY DEBUG ===');
        // \Log::info('Role Check:', [
        //     'raw_role' => $user->role,
        //     'is_agent_method' => $user->isAgent(),
        //     'is_admin_method' => $user->isAdmin()
        // ]);

        // Use the existing isAgent() method
        if ($user->isAgent()) {
            $agentOptions = [$user->id => $user->name];
           // \Log::info('Agent view - showing only current agent');
        } else {
            // For admin, show all agents
            $agentOptions = User::where('role', 1)  // Direct query for agents
                ->pluck('name', 'id')
                ->toArray();
            \Log::info('Admin view - showing all agents');
        }

        //\Log::info('Agent Options:', $agentOptions);

        return Inertia::render('Admin/AddProperty', [
            'propertyTypes' => PropertyType::pluck('name', 'category'),
            'userTypes' => UserType::toSelectArray(),
            'countries' => Schema::hasTable('countries') ? Country::pluck('name', 'id') : [],
            'defaultData' => [
                'states' => [],
                'cities' => [],
                'currency' => null,
            ],
            'customerOptions' => Schema::hasTable('customers') ? Customer::pluck('name', 'id') : [],
            'agentOptions' => $agentOptions,
            'propertySizeUnits' => Schema::hasTable('property_size_units')
                ? DB::table('property_size_units')->pluck('unit_key', 'id')
                : [],
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->isAgent() ? 1 : 0
            ],
        ]);
    }
}
