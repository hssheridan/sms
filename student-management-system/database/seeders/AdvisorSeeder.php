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
            ->hasAttached(Student::inRandomOrder()->take(random_int(0,20))->get('id'))
            ->hasAttached(Course::inRandomOrder()->take(random_int(0,10))->get('id'))
            ->count(7)
            ->create();
    }
}
