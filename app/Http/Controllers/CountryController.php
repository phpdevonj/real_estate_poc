<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function getCountryData($id)
    {
        // Fetch the country data based on $countryId
        $country = Country::findOrFail($id);

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        return response()->json([
            'states' => $country->states,
            'cities' => $country->cities,
            'currency' => $country->currency,
        ]);
    }
}
