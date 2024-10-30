<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::create([
            'name' => 'Basic Package',
            'type' => 'basic',
            'description' => 'basic package',
        ]);
        Package::create([
            'name' => 'Advanced Package',
            'type' => 'advanced',
            'description' => 'advanced package',
        ]);
    }
}
