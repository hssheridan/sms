<?php

namespace Database\Seeders;

use App\Models\Advisor;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Advisor::factory()
            ->count(7)
            ->create();
    }
}
