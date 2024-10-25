<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 20 vendors
        for ($i = 1; $i <= 20; $i++) {
            DB::table('vendors')->insert([
                'title' => 'Vendor ' . $i,
                'description' => 'Description for Vendor ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
