<?php

namespace Database\Seeders;

use DB;
use File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // List of SQL files to execute
         $sqlFiles = [
            database_path('countries.sql'),
            database_path('states.sql'),
            database_path('cities.sql'),
        ];

        DB::beginTransaction(); // Start the transaction
        try {
            foreach ($sqlFiles as $file) {
                if (File::exists($file)) {
                    $this->command->info("Executing file: " . $file);

                    // Disable foreign key checks
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                    // Execute the SQL
                    DB::unprepared(File::get($file));

                    // Re-enable foreign key checks
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    $this->command->info("Successfully executed: " . $file);
                } else {
                    throw new \Exception("File not found: " . $file);
                }
            }

            DB::commit(); // Commit the transaction if all files execute successfully
        } catch (\Exception $e) {
            DB::rollBack(); // Roll back if any file fails
            $this->command->error("Seeding failed: " . $e->getMessage());
        }
    }
}
