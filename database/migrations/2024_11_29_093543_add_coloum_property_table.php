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
        Schema::create('properties', function (Blueprint $table) {
            $table->string('title'); // Property title
            $table->text('description')->nullable(); // Description
            $table->string('no')->nullable(); // House or Property No
            $table->string('street')->nullable(); // Street
            $table->string('city'); // City
            $table->string('state'); // State
            $table->string('country'); // Country
            $table->decimal('price', 10, 2); // Price
            $table->string('currency', 10); // Currency Code
            $table->json('photos')->nullable(); // JSON Array of Photos
            $table->float('size')->nullable(); // Size of the Property
            $table->string('unit', 20)->nullable(); // Measuring Unit
            $table->unsignedBigInteger('agent_id'); // Agent (Foreign Key)
            $table->unsignedBigInteger('customer_id')->nullable(); // Customer (Foreign Key)
            $table->boolean('flag')->default(0); // Sold (1) / Unsold (0)
            $table->tinyInteger('status')->default(0); // 0 for inactive, 1 for active
            $table->timestamps(); // Created and Updated timestamps

            // Foreign key constraints
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
