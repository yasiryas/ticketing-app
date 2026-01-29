<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::insert([
            ['name' => 'IT Department', 'description' => 'Handles all IT related issues.'],
            ['name' => 'HR Department', 'description' => 'Manages employee relations and recruitment.'],
            ['name' => 'Finance Department', 'description' => 'Oversees financial operations and budgeting.'],
        ]);
    }
}
