<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 20 options for each question
        $questions = DB::table('questions')->pluck('id');
        
        foreach ($questions as $questionId) {
            for ($i = 1; $i <= 4; $i++) { // Assume each question has 4 options
                DB::table('options')->insert([
                    'question_id' => $questionId,
                    'title' => 'Option ' . $i . ' for Question ' . $questionId,
                    'weight' => rand(1, 4),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
