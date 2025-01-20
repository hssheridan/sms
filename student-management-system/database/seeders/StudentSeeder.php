<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::factory()
            ->count(20)
            ->create();

            foreach($students as $student)
            {
                $student
                    ->addMedia(public_path('seeder-images\\'.rand(1,3).'.jpg'))
                    ->preservingOriginal()
                    ->toMediaCollection('default');
            }
    }
}
