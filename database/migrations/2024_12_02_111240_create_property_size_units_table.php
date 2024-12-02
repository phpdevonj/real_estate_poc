<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('property_size_units', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('unit_key')->unique(); // Key for the unit (e.g., 'sqft')
            $table->string('unit_name'); // Full name (e.g., 'Square Feet')
            $table->string('abbreviation')->nullable(); // Abbreviation (e.g., 'sq ft')
            $table->timestamps();
        });


        // Insert predefined property size units
        DB::table('property_size_units')->insert([
            ['unit_key' => 'sqft', 'unit_name' => 'Square Feet', 'abbreviation' => 'sq ft'],
            ['unit_key' => 'sqm', 'unit_name' => 'Square Meters', 'abbreviation' => 'sq m'],
            ['unit_key' => 'acre', 'unit_name' => 'Acres', 'abbreviation' => null],
            ['unit_key' => 'hectare', 'unit_name' => 'Hectares', 'abbreviation' => null],
            ['unit_key' => 'sqyd', 'unit_name' => 'Square Yards', 'abbreviation' => 'sq yd'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('property_size_units');
    }
};
