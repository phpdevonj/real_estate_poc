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
        Schema::table('users', function (Blueprint $table) {
            //$table->string('username')->unique()->after('id'); // Add username column
            // $table->string('address')->nullable()->after('username'); // Add address column
            // $table->string('mobile')->nullable()->after('address'); // Add mobile column
            // $table->string('role')->default('agent')->after('mobile'); // Add role column with default value
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->dropColumn([ 'address', 'mobile', 'role']);
        });
    }
};
