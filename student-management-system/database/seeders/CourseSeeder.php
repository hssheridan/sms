<?php

namespace Database\Seeders;

use App\Models\Advisor;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::factory()
            ->hasAttached(Student::inRandomOrder()->take(random_int(0,20))->get('id'))
            ->count(10)
            ->create();
    }
}
