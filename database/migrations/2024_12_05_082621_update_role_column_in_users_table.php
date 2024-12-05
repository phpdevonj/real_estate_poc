<?php

use App\Enums\UserType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
       {
           // Convert existing string values to integers
           DB::table('users')->where('role', 'agent')->update(['role' => UserType::Agent]);
           DB::table('users')->where('role', 'admin')->update(['role' => UserType::Admin]);

           // Change the column type to integer
           Schema::table('users', function (Blueprint $table) {
               $table->integer('role')->default(UserType::Agent)->change();
           });
       }

    /**
     * Reverse the migrations.
     */
    public function down()
       {
           // Revert the column type to string
           Schema::table('users', function (Blueprint $table) {
               $table->string('role')->default('agent')->change();
           });

           // Convert integer values back to strings
           DB::table('users')->where('role', UserType::Agent)->update(['role' => 'agent']);
           DB::table('users')->where('role', UserType::Admin)->update(['role' => 'admin']);
       }
};
