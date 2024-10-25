<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 20 questions
        for ($i = 1; $i <= 20; $i++) {
            DB::table('questions')->insert([
                'vendor_id' => rand(1, 20), // Randomly associate with a vendor
                'title' => 'Question Title ' . $i,
                'type' => rand(0, 1) ? 'multiple_choice' : 'yes_no', // Randomly assign type
                'weight' => rand(1, 4),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
