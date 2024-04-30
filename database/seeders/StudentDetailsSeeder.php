<?php

namespace Database\Seeders;

use App\Models\StudentDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudentDetails::factory()->count(1800)->create();
    }
}
