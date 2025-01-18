<?php

namespace Database\Seeders;

use App\Models\Advisor;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdvisorSeeder::class,
            StudentSeeder::class,
            CourseSeeder::class,
        ]);
    }
}
