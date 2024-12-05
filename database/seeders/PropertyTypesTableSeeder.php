<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propertyTypes = [
            ['name' => 'Single-Family Home', 'category' => 'Residential'],
            ['name' => 'Multi-Family Home', 'category' => 'Residential'],
            ['name' => 'Condominium', 'category' => 'Residential'],
            ['name' => 'Townhouse', 'category' => 'Residential'],
            ['name' => 'Apartment', 'category' => 'Residential'],
            ['name' => 'Studio Apartment', 'category' => 'Residential'],
            ['name' => 'Penthouse', 'category' => 'Residential'],
            ['name' => 'Villa', 'category' => 'Residential'],
            ['name' => 'Bungalow', 'category' => 'Residential'],
            ['name' => 'Office Space', 'category' => 'Commercial'],
            ['name' => 'Retail Space', 'category' => 'Commercial'],
            ['name' => 'Warehouse', 'category' => 'Commercial'],
            ['name' => 'Industrial Space', 'category' => 'Commercial'],
            ['name' => 'Residential Land', 'category' => 'Land'],
            ['name' => 'Commercial Land', 'category' => 'Land'],
            ['name' => 'Agricultural Land', 'category' => 'Land'],
            ['name' => 'Luxury Home', 'category' => 'Specialty'],
            ['name' => 'Farmhouse', 'category' => 'Specialty'],
            ['name' => 'Vacation Rental', 'category' => 'Specialty'],
            ['name' => 'Eco-Friendly Home', 'category' => 'Specialty'],
        ];

        DB::table('property_types')->insert($propertyTypes);

    }
}
